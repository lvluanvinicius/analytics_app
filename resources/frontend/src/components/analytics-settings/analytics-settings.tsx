import {
    Menubar,
    MenubarCheckboxItem,
    MenubarContent,
    MenubarItem,
    MenubarMenu,
    MenubarRadioGroup,
    MenubarRadioItem,
    MenubarSeparator,
    MenubarShortcut,
    MenubarSub,
    MenubarSubContent,
    MenubarSubTrigger,
    MenubarTrigger,
} from "@/components/ui/menubar";

export function AnalyticsSettingsLayout() {
    return (
        <Menubar>
            <MenubarMenu>
                <MenubarTrigger>Equpamentos</MenubarTrigger>
                <MenubarContent>
                    <MenubarItem>Novo</MenubarItem>
                </MenubarContent>
            </MenubarMenu>
        </Menubar>
    );
}
