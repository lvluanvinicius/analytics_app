import { PanelRight } from "lucide-react";
import { SidebarTrigger } from "./ui/sidebar";

export function SidebarHeader() {
    return (
        <header className="border-b h-12 flex justify-between items-center pr-4">
            <SidebarTrigger className="h-full rounded-tl-xl w-12">
                <PanelRight />
            </SidebarTrigger>
        </header>
    );
}
