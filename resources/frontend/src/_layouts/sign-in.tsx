import { api } from "@/services/axios";
import { isAxiosError } from "axios";
import { useLayoutEffect } from "react";
import { Outlet } from "react-router-dom";
import { toast } from "sonner";

export function SignInLayout() {
    useLayoutEffect(() => {
        const interceptorId = api.interceptors.response.use(
            (response) => response,
            (error) => {
                if (isAxiosError(error)) {
                    const status = error.response?.status;
                    const code = error.code;

                    if (status === 401) {
                        toast.error(
                            "Houve um problema de permissão de acesso. Por favor, tente novamete mais tarde.",
                        );
                    }

                    if (status === 400 && code === "ERR_BAD_REQUEST") {
                        toast.error(error.response?.data?.message);
                    }

                    if (
                        status === 422 &&
                        error.response &&
                        error.response.data
                    ) {
                        const data: ActionsResponse<[]> = error.response.data;

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
    }, []);

    return (
        <div className="min-h-screen">
            <Outlet />
        </div>
    );
}
