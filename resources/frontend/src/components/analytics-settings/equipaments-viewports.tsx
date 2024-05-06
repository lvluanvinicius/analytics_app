import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogFooter,
} from "@/components/ui/dialog";
import { useState } from "react";
import { Button } from "../ui/button";
import { getEquipamentsPorts } from "@/services/queries/get-equipaments-ports";
import { useQuery } from "@tanstack/react-query";

interface EquipamentsViewportsProps {
    equipamentName: string;
}

export function EquipamentsViewports({
    equipamentName,
}: EquipamentsViewportsProps) {
    const [open, setOpen] = useState(false);

    const { data: ports } = useQuery({
        queryFn: () => getEquipamentsPorts({ equipament: equipamentName }),
        queryKey: ["equipaments-ports", equipamentName],
        enabled: open,
    });

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button variant={"outline"} size={"sm"}>
                    Ver Portas
                </Button>
            </DialogTrigger>

            <DialogContent className="pb-10">
                <DialogHeader>
                    <DialogTitle>Portas de {equipamentName}</DialogTitle>
                </DialogHeader>

                <div className="flex flex-col gap-4">
                    <div className="max-h-[400px] flex-1 overflow-auto pr-4">
                        {ports?.data.map((port) => {
                            return (
                                <div
                                    key={port._id}
                                    className="flex items-center justify-between border-b py-4 pb-2"
                                >
                                    <span>{port._id}</span>
                                    <span>{port.port}</span>
                                </div>
                            );
                        })}
                    </div>

                    <DialogFooter>
                        <Button
                            type="button"
                            onClick={() => setOpen(!open)}
                            variant="secondary"
                            className="w-full text-[1rem]"
                        >
                            Fechar
                        </Button>
                    </DialogFooter>
                </div>
            </DialogContent>
        </Dialog>
    );
}
