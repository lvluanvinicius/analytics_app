import { Sidebar } from "@/components/sidebar/sidebar";
import { api } from "@/services/axios";
import { isAxiosError } from "axios";
import { useLayoutEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Outlet } from "react-router-dom";
import { toast } from "sonner";

export function AppLayout() {
    const navigate = useNavigate();

    useLayoutEffect(
        function () {
            const interceptorId = api.interceptors.response.use(
                (response) => response,
                (error) => {
                    if (isAxiosError(error)) {
                        const status = error.response?.status;
                        const code = error.code;

                        if (status === 401) {
                            navigate("/sign-in", {
                                replace: true,
                            });
                        }

                        if (status === 400 && code === "ERR_BAD_REQUEST") {
                            toast.error(error.response?.data?.message);
                        }

                        if (
                            status === 422 &&
                            error.response &&
                            error.response.data
                        ) {
                            const data: ActionsResponse<[]> =
                                error.response.data;

                            for (let err in data.errors) {
                                for (let m of data.errors[err]) {
                                    toast.error(m);
                                }
                            }
                        }
                    }

                    return Promise.reject(error);
                },
            );

            return () => {
                api.interceptors.response.eject(interceptorId);
            };
        },
        [navigate],
    );

    return (
        <div className="flex min-h-screen  antialiased">
            <Sidebar />
            <div className="light:bg-gray-100 ml-[70px] flex flex-1 flex-col gap-4 p-8 pt-4">
                <Outlet />
            </div>
        </div>
    );
}
