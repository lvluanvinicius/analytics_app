import { useState } from "react";
import {
    Dialog,
    DialogContent,
    DialogTitle,
    DialogTrigger,
} from "../ui/dialog";

export function Selector() {
    const [open, setOpen] = useState(true);

    function handleSelected() {
        setOpen(false);
    }

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger>Selecione</DialogTrigger>
            <DialogContent>
                <DialogTitle>Selecione um {"tetste"}</DialogTitle>
                <div className="">
                    <ul className="flex flex-col gap-2">
                        <li
                            className="w-full cursor-pointer rounded-md border px-2 py-2 text-muted-foreground"
                            onClick={() => handleSelected("selecionando...")}
                        >
                            Item 01
                        </li>
                        <li
                            className="w-full cursor-pointer rounded-md border px-2 py-2 text-muted-foreground"
                            onClick={() => handleSelected("selecionando...")}
                        >
                            Item 02
                        </li>
                        <li
                            className="w-full cursor-pointer rounded-md border px-2 py-2 text-muted-foreground"
                            onClick={() => handleSelected("selecionando...")}
                        >
                            Item 03
                        </li>
                        <li
                            className="w-full cursor-pointer rounded-md border px-2 py-2 text-muted-foreground"
                            onClick={() => handleSelected("selecionando...")}
                        >
                            Item 04
                        </li>
                    </ul>
                </div>
            </DialogContent>
        </Dialog>
    );
}
