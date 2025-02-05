import * as React from "react";
import { Command, SquareTerminal } from "lucide-react";

import { NavMain } from "@/components/nav-main";
import { NavUser } from "@/components/nav-user";
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from "@/components/ui/sidebar";
import { usePage } from "@inertiajs/react";

const data = {
    user: {
        name: "shadcn",
        email: "m@example.com",
        avatar: "/avatars/shadcn.jpg",
    },
    navMain: [
        {
            title: "Analytics",
            url: "#",
            icon: SquareTerminal,
            isActive: true,
            items: [
                {
                    title: "ONU Inventory",
                    url: route("app.onu-nventory"),
                },
            ],
        },

        {
            title: "Equipamentos",
            url: "#",
            icon: SquareTerminal,
            isActive: true,
            items: [
                {
                    title: "Listar",
                    url: route("app.equipaments.index"),
                },
                {
                    title: "Adicionar",
                    url: route("app.equipaments.create"),
                },
            ],
        },
    ],
};

export function AppSidebar({ ...props }: React.ComponentProps<typeof Sidebar>) {
    const { auth } = usePage().props;

    if (!auth) {
        window.location.href = "/";
        return;
    }

    return (
        <Sidebar variant="inset" {...props}>
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <a href="#">
                                <div className="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
                                    <Command className="size-4" />
                                </div>
                                <div className="grid flex-1 text-left text-sm leading-tight">
                                    <span className="truncate font-semibold">
                                        Analytics Api
                                    </span>
                                    <span className="truncate text-xs">
                                        Luxe Softwares
                                    </span>
                                </div>
                            </a>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>
            <SidebarContent>
                <NavMain items={data.navMain} title="Inventory" />
            </SidebarContent>
            <SidebarFooter>
                <NavUser
                    user={{
                        avatar: "",
                        email: auth.user.email,
                        name: auth.user.name,
                    }}
                />
            </SidebarFooter>
        </Sidebar>
    );
}
