import { useState } from "react";
import { Button } from "../ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogFooter,
} from "@/components/ui/dialog";

import { Settings as SettingsIcon } from "lucide-react";
import { ModeToggle } from "../themes/mode-toggle";

export function Settings() {
    const [open, setOpen] = useState(false);

    return (
        <Dialog open={open} onOpenChange={() => setOpen(!open)}>
            <DialogTrigger asChild>
                <Button size={"icon"} variant={"outline"}>
                    <SettingsIcon />
                </Button>
            </DialogTrigger>

            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Configurações</DialogTitle>
                    <DialogDescription>Configurações gerais</DialogDescription>
                </DialogHeader>

                <div className="mt-4">
                    <ul className="">
                        <li className="flex justify-between border-b pb-1">
                            <span className="text-foreground">Tema</span>
                            <span>
                                <ModeToggle />
                            </span>
                        </li>
                    </ul>

                    <DialogFooter className="mt-4">
                        <span className="text-[12px] text-muted-foreground">
                            Todas as configuração são refletidas no exato
                            momento de cada ação listada.
                        </span>
                    </DialogFooter>
                </div>
            </DialogContent>
        </Dialog>
    );
}
