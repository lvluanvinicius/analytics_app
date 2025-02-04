import { Button } from "@/components/ui/button";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { ScrollArea } from "@/components/ui/scroll-area";
import { application } from "@/services/app";
import { ActionsResponse } from "@/types/api";
import { EquipamentInterface } from "@/types/equipament";
import { EquipamentPortInterface } from "@/types/equipament-port";
import { useQuery } from "@tanstack/react-query";
import { useState } from "react";

interface TableEquipamentsProps {
    data: EquipamentInterface;
}

export function ViewPorts({ data }: TableEquipamentsProps) {
    const [open, setOpen] = useState<boolean>(false);

    const { data: ports } = useQuery({
        queryKey: ["equipament-ports"],
        queryFn: async function () {
            const response = await application.get<
                ActionsResponse<EquipamentPortInterface[]>
            >(`/equipament/${data.uuid}/ports`);

            if (response.data) {
                return response.data.data;
            }

            return null;
        },
        enabled: !!open,
    });

    if (!ports) {
        return null;
    }

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button size="icon">{data.n_port}</Button>
            </DialogTrigger>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Todas as Portas</DialogTitle>
                </DialogHeader>

                <div>
                    <ScrollArea>
                        {ports.map(function (port, index) {
                            return (
                                <div className="border px-2 py-1 flex justify-between">
                                    <span>{data.name}</span>
                                    <span>{port.port}</span>
                                </div>
                            );
                        })}
                    </ScrollArea>
                </div>

                <DialogFooter>
                    <DialogClose asChild>
                        <Button variant={"secondary"}>Fechar</Button>
                    </DialogClose>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
