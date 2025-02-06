import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import { ScrollArea } from "@/components/ui/scroll-area";
import { cn } from "@/lib/utils";
import { application } from "@/services/app";
import { queryClient } from "@/services/queryClient";
import { ActionsResponse } from "@/types/api";
import { GPonOnusDBMInterface } from "@/types/onu-names";
import { useQuery } from "@tanstack/react-query";
import { useEffect, useState } from "react";

export function SelectOnuNames({
    equipament,
    port,
    value,
    changeValue,
    className,
    loadData,
}: {
    equipament: string;
    port: string;
    value: string;
    changeValue: (value: string) => void;
    className?: string;
    loadData?: GPonOnusDBMInterface;
}) {
    const [open, setOpen] = useState<boolean>(false);
    const [search, setSearch] = useState<string | null>(null);
    const [selected, setSelected] = useState<GPonOnusDBMInterface | null>(null);

    const { data: onuNames, isLoading } = useQuery({
        queryKey: ["onu-names", search],
        queryFn: async function () {
            const response = await application.get<
                ActionsResponse<GPonOnusDBMInterface[]>
            >(route("app.onu-names", [equipament, port.replaceAll("/", "-")]), {
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
        if (onuNames) {
            const it = onuNames.find((c) => c.NAME === item);

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
                queryKey: ["onu-names"],
            });
        },
        [value, port, equipament]
    );

    return (
        <Popover open={open} onOpenChange={setOpen}>
            <PopoverTrigger asChild>
                <Button
                    variant="outline"
                    className={cn("justify-start ", className)}
                >
                    {value
                        ? value
                        : selected
                        ? selected.NAME
                        : "Selecione uma onu"}
                </Button>
            </PopoverTrigger>
            <PopoverContent className="min-w-[27rem]">
                <div className="p-2">
                    <Input
                        placeholder="Buscar onu..."
                        value={search || ""}
                        onChange={(e) => setSearch(e.currentTarget.value)}
                    />

                    <div className="mt-2">
                        {isLoading && (
                            <div className="bg-secondary p-1 text-center text-muted-foreground">
                                Buscando...
                            </div>
                        )}
                        {!isLoading && onuNames && onuNames.length === 0 && (
                            <div className="bg-secondary p-1 text-center text-muted-foreground">
                                Nenhuma onu encontrada.
                            </div>
                        )}

                        <ScrollArea className="h-44">
                            {onuNames &&
                                onuNames.map(function (onuName, index) {
                                    return (
                                        <div
                                            key={index}
                                            onClick={() =>
                                                handleSelect(onuName.NAME)
                                            }
                                            className="flex text-xs mb-2 px-2 justify-center w-full cursor-pointer items-center rounded-md bg-secondary py-2 pl-4"
                                        >
                                            {onuName.NAME}
                                        </div>
                                    );
                                })}
                        </ScrollArea>
                    </div>
                </div>
            </PopoverContent>
        </Popover>
    );
}
