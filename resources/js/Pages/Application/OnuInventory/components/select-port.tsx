import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import { cn } from "@/lib/utils";
import { application } from "@/services/app";
import { queryClient } from "@/services/queryClient";
import { ActionsResponse } from "@/types/api";
import { EquipamentPortInterface } from "@/types/equipament-port";
import { useQuery } from "@tanstack/react-query";
import { useEffect, useState } from "react";

export function SelectPort({
    equipament,
    value,
    changeValue,
    className,
    loadData,
}: {
    equipament: string;
    value: string;
    changeValue: (value: string) => void;
    className?: string;
    loadData?: EquipamentPortInterface;
}) {
    const [open, setOpen] = useState<boolean>(false);
    const [search, setSearch] = useState<string>("");
    const [selected, setSelected] = useState<EquipamentPortInterface | null>(
        null
    );

    const { data: ports, isLoading } = useQuery({
        queryKey: ["equipament-ports", search],
        queryFn: async function () {
            const response = await application.get<
                ActionsResponse<EquipamentPortInterface[]>
            >(`/equipament/${equipament}/ports`, {
                params: {
                    search,
                },
            });

            if (response.data) {
                return response.data.data;
            }

            return null;
        },
        enabled: !!open,
    });

    async function handleSelect(item: string) {
        if (ports) {
            const it = ports.find((c) => c.port === item);

            if (it) {
                setSelected(it);
            }
        }

        changeValue(item);
        setOpen(false);
    }

    useEffect(
        function () {
            queryClient.invalidateQueries({
                queryKey: ["equipament-ports"],
            });
        },
        [value]
    );

    return (
        <Popover open={open} onOpenChange={setOpen}>
            <PopoverTrigger asChild>
                <Button
                    variant="outline"
                    className={cn("justify-start", className)}
                >
                    {value
                        ? value
                        : selected
                        ? selected.port
                        : "Selecione uma porta"}
                </Button>
            </PopoverTrigger>
            <PopoverContent className="">
                <div className="p-2">
                    <Input
                        placeholder="Buscar porta..."
                        value={search}
                        onChange={(e) => setSearch(e.currentTarget.value)}
                    />

                    <div className="mt-2">
                        {isLoading && (
                            <div className="bg-secondary p-1 text-center text-muted-foreground">
                                Buscando...
                            </div>
                        )}
                        {!isLoading && ports && ports.length === 0 && (
                            <div className="bg-secondary p-1 text-center text-muted-foreground">
                                Nenhuma porta encontrada.
                            </div>
                        )}

                        <div className="flex flex-col gap-2">
                            {ports &&
                                ports.map(function (port, index) {
                                    return (
                                        <div
                                            key={index}
                                            onClick={() =>
                                                handleSelect(port.port)
                                            }
                                            className="flex w-full cursor-pointer items-center rounded-md bg-secondary py-2 pl-4"
                                        >
                                            {port.port}
                                        </div>
                                    );
                                })}
                        </div>
                    </div>
                </div>
            </PopoverContent>
        </Popover>
    );
}
