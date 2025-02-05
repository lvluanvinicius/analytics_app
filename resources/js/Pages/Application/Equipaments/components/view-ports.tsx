import { Button } from "@/components/ui/button";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
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
            >(`/equipament/${data.name}/ports`);

            if (response.data) {
                return response.data.data;
            }

            return null;
        },
        enabled: !!open,
    });

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button size="sm">Portas</Button>
            </DialogTrigger>
            <DialogContent className="md:max-h-[70vh]">
                <DialogHeader>
                    <DialogTitle>Portas</DialogTitle>
                    <DialogDescription>
                        Esses dados seriam apenas para vizualização e filtros
                        nos gráficos.
                    </DialogDescription>
                </DialogHeader>

                <ScrollArea className="md:h-[50vh] px-2">
                    {ports ? (
                        ports.map(function (port, index) {
                            return (
                                <div
                                    key={index}
                                    className="border px-2 py-1 flex justify-between"
                                >
                                    <span>{data.name}</span>
                                    <span>{port.port}</span>
                                </div>
                            );
                        })
                    ) : (
                        <span className="border px-2 py-1 flex justify-between">
                            Nada a exibir
                        </span>
                    )}
                </ScrollArea>

                <DialogFooter>
                    <DialogClose asChild>
                        <Button variant={"secondary"}>Fechar</Button>
                    </DialogClose>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
