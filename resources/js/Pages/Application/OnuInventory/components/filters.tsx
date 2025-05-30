import { SelectEquipament } from "@/components/application/select-equipament";
import { Button } from "@/components/ui/button";
import { transformSearchParams } from "@/tools/urls";
import { router, useForm, usePage } from "@inertiajs/react";
import { FormEvent, useEffect, useState } from "react";
import { SelectPort } from "./select-port";
import { SelectOnuNames } from "./select-onu-names";
import { Skeleton } from "@/components/ui/skeleton";

export function FiltersGet() {
    const { url } = usePage();

    const [processing, setProcessing] = useState(false);

    const { data, setData } = useForm({
        equipament: "",
        port: "",
        onuName: "",
    });

    const handleSearch = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const params: Record<string, string | number> = {};
        const uri = url.split("?")[0];
        const currentQuery = url.split("?")[1];

        // Inserindo todos os parametros dentro do objeto params.
        new URLSearchParams(currentQuery).forEach((v, k) => (params[k] = v));

        setData("equipament", params.equipament as string);
        setData("port", params.port as string);
        setData("onuName", params.onuName as string);

        router.get(
            `${uri}?${transformSearchParams({ ...data })}`,
            {},
            {
                onBefore() {
                    setProcessing(true);
                },
                onFinish() {
                    setProcessing(false);
                },
            }
        );
    };

    useEffect(function () {
        const params: Record<string, string | number> = {};
        const currentQuery = url.split("?")[1];

        // Inserindo todos os parametros dentro do objeto params.
        new URLSearchParams(currentQuery).forEach((v, k) => (params[k] = v));

        if (params.equipament) {
            setData("equipament", params.equipament as string);
        }

        if (params.equipament) {
            setData("port", params.port as string);
        }

        if (params.equipament) {
            setData("onuName", params.onuName as string);
        }
    }, []);

    return (
        <form
            className="w-full p-4 grid grid-cols-3 gap-4 border !rounded-md bg-sidebar"
            onSubmit={handleSearch}
        >
            {processing ? (
                <Skeleton className="h-9 w-full rounded-md border bg-background" />
            ) : (
                <SelectEquipament
                    className="border h-9 col-span-3 xl:col-span-1"
                    value={data.equipament}
                    changeValue={(v) => setData("equipament", v)}
                />
            )}

            {processing ? (
                <Skeleton className="h-9 w-full rounded-md border bg-background" />
            ) : (
                <SelectPort
                    className="border h-9 col-span-3 xl:col-span-1"
                    changeValue={(v) => setData("port", v)}
                    value={data.port}
                />
            )}

            {processing ? (
                <Skeleton className="h-9 w-full rounded-md border bg-background" />
            ) : (
                <SelectOnuNames
                    className="border h-9 col-span-3 xl:col-span-1"
                    changeValue={(v) => setData("onuName", v)}
                    value={data.onuName}
                />
            )}

            <div className="col-span-3 flex justify-end items-center">
                <Button>Filtrar</Button>
            </div>
        </form>
    );
}
