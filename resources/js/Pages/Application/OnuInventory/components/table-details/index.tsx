import {
    Table,
    TableBody,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { TableDetailRow } from "./table-row";
import { useQuery } from "@tanstack/react-query";
import { GPonOnusDBMInterface } from "@/types/onu-names";
import { ActionsResponse } from "@/types/api";
import { application } from "@/services/app";
import { useEffect, useState } from "react";
import { usePage } from "@inertiajs/react";
import { TableDetailRowSkeleton } from "./table-row-skeleton";

// table-details.tsx
export function TableDetails() {
    const { url } = usePage();
    const [equipament, setEquipament] = useState<string | null>(null);
    const [port, setPort] = useState<string | null>(null);

    const { data: onuNames, isLoading } = useQuery({
        queryKey: ["table-details", equipament, port],
        queryFn: async function () {
            const response = await application.get<
                ActionsResponse<GPonOnusDBMInterface[]>
            >(route("app.inventory-data"), {
                params: {
                    equipament,
                    port,
                },
            });

            if (response.data) {
                return response.data.data;
            }

            return null;
        },
        enabled: !!(!!equipament && !!port),
    });

    useEffect(
        function () {
            const params: Record<string, string | number> = {};
            const currentQuery = url.split("?")[1];

            // Inserindo todos os parametros dentro do objeto params.
            new URLSearchParams(currentQuery).forEach(
                (v, k) => (params[k] = v)
            );

            if (params.equipament) {
                setEquipament(params.equipament as string);
            }

            if (params.port) {
                setPort(params.port as string);
            }
        },
        [url]
    );

    return (
        <div className="bg-sidebar !rounded-md border px-6 py-4">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead className="whitespace-nowrap">
                            NAME
                        </TableHead>
                        <TableHead className="whitespace-nowrap">
                            SERIAL
                        </TableHead>
                        <TableHead className="whitespace-nowrap">
                            DEVICE
                        </TableHead>
                        <TableHead className="whitespace-nowrap">
                            PORT
                        </TableHead>
                        <TableHead className="whitespace-nowrap">
                            RXDBM
                        </TableHead>
                        <TableHead className="whitespace-nowrap">
                            TXDBM
                        </TableHead>
                        <TableHead className="whitespace-nowrap">
                            COLLECTION_DATE
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {onuNames
                        ? onuNames.map(function (data, index) {
                              return <TableDetailRow key={index} data={data} />;
                          })
                        : [
                              0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
                              15, 16, 17, 18, 19, 20,
                          ].map(function (_, index) {
                              return <TableDetailRowSkeleton key={index} />;
                          })}
                </TableBody>
            </Table>
        </div>
    );
}
