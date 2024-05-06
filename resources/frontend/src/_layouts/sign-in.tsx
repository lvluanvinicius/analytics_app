import { Outlet } from "react-router-dom";

export function SignInLayout() {
    return (
        <div className="min-h-screen">
            <Outlet />
        </div>
    );
}
