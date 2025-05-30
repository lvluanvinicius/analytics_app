import { application } from "@/services/app";
import { ActionsResponse, ApiResponse } from "@/types/api";
import { EquipamentInterface } from "@/types/equipament";
import { useQuery } from "@tanstack/react-query";
import { useEffect, useState } from "react";
import { Popover, PopoverContent, PopoverTrigger } from "../ui/popover";
import { Button } from "../ui/button";
import { Input } from "../ui/input";
import { cn } from "@/lib/utils";

export function SelectEquipament({
    value,
    changeValue,
    className,
    loadData,
}: {
    value: string;
    changeValue: (value: string) => void;
    className?: string;
    loadData?: EquipamentInterface;
}) {
    const [open, setOpen] = useState<boolean>(false);
    const [search, setSearch] = useState<string>("");
    const [selected, setSelected] = useState<EquipamentInterface | null>(null);

    const handleLoadItem = (item: EquipamentInterface | null) => {
        setSelected(item);
    };

    const { data: equipaments, isLoading } = useQuery({
        queryKey: ["select-warehouses", search],
        queryFn: async function () {
            const response = await application.get<
                ActionsResponse<ApiResponse<EquipamentInterface[]>>
            >(route("app.equipaments-json"), {
                params: {
                    search,
                },
            });

            if (response.data && response.status === 200) {
                const { data } = response.data;
                return data.data;
            }

            return null;
        },
        enabled: !!open,
    });

    async function handleSelect(item: string) {
        if (equipaments) {
            const it = equipaments.find((c) => c.DEVICE === item);

            if (it) {
                setSelected(it);
            }
        }

        changeValue(item);
        setOpen(false);
    }

    useEffect(() => {
        if (loadData) {
            handleLoadItem(loadData);
        }
    }, [loadData]);

    return (
        <Popover open={open} onOpenChange={setOpen}>
            <PopoverTrigger asChild>
                <Button
                    variant="outline"
                    className={cn("justify-start w-full ", className)}
                >
                    {value
                        ? value
                        : selected
                        ? selected.DEVICE
                        : "Selecione um equipamento"}
                </Button>
            </PopoverTrigger>
            <PopoverContent className="">
                <div className="p-2">
                    <Input
                        placeholder="Buscar equipamento..."
                        value={search}
                        onChange={(e) => setSearch(e.currentTarget.value)}
                    />

                    <div className="mt-2">
                        {isLoading && (
                            <div className="bg-secondary p-1 text-center text-muted-foreground">
                                Buscando...
                            </div>
                        )}
                        {!isLoading &&
                            equipaments &&
                            equipaments.length === 0 && (
                                <div className="bg-secondary p-1 text-center text-muted-foreground">
                                    Nenhum equipamento encontrado.
                                </div>
                            )}

                        <div className="flex flex-col gap-2">
                            {equipaments &&
                                equipaments.map(function (equipament, index) {
                                    return (
                                        <div
                                            key={index}
                                            onClick={() =>
                                                handleSelect(equipament.DEVICE)
                                            }
                                            className="flex w-full cursor-pointer items-center rounded-md bg-secondary py-2 pl-4"
                                        >
                                            {equipament.DEVICE}
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
