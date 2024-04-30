import { Sidebar } from "@/components/sidebar/sidebar";
import { api } from "@/services/axios";
import { isAxiosError } from "axios";
import { useLayoutEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Outlet } from "react-router-dom";

export function AppLayout() {
    // const navigate = useNavigate();

    // useLayoutEffect(
    //     function () {
    //         const interceptorId = api.interceptors.response.use(
    //             (response) => response,
    //             (error) => {
    //                 if (isAxiosError(error)) {
    //                     const status = error.response?.status;
    //                     const statusText = error.response?.statusText;

    //                     if (status === 401 && statusText === "Unauthorized") {
    //                         navigate("/app/sign-in", {
    //                             replace: true,
    //                         });
    //                     }
    //                 }

    //                 return Promise.reject(error);
    //             },
    //         );

    //         return () => {
    //             api.interceptors.response.eject(interceptorId);
    //         };
    //     },
    //     [navigate],
    // );

    return (
        <div className="flex min-h-screen  antialiased">
            <Sidebar />
            <div className="light:bg-gray-100 flex flex-1 flex-col gap-4 p-8 pt-4">
                <Outlet />
            </div>
        </div>
    );
}
