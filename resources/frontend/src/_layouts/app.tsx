import { Sidebar } from "@/components/sidebar/sidebar";
import { Outlet } from "react-router-dom";

export function AppLayout() {
    return (
        <div className="flex min-h-screen  antialiased">
            <Sidebar />
            <div className="light:bg-gray-100 flex flex-1 flex-col gap-4 p-8 pt-4">
                <Outlet />
            </div>
        </div>
    );
}
