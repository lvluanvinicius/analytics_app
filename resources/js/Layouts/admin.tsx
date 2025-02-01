import { SidebarInset, SidebarProvider } from "../components/ui/sidebar";
import { AppSidebar } from "../components/app-sidebar";
import { ReactNode } from "react";
import { Head } from "@inertiajs/react";

export default function DefaultLayout({
    children,
    pageTitle,
}: {
    children: ReactNode;
    pageTitle?: string;
}) {
    return (
        <>
            <Head title={pageTitle ? pageTitle : ""} />
            <SidebarProvider>
                <AppSidebar />
                <SidebarInset className="overflow-y-auto">
                    {/* <Navbar /> */}
                    <main className="px-8 py-4">{children}</main>
                </SidebarInset>
            </SidebarProvider>
        </>
    );
}
