import { csrfCookie } from "@/services/csrf-cookie";
import { useQuery } from "@tanstack/react-query";
import { Outlet } from "react-router-dom";

export function SignInLayout() {
    return (
        <div className="min-h-screen">
            <Outlet />
        </div>
    );
}
