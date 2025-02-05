import { SelectEquipament } from "@/components/application/select-equipament";
import { Button } from "@/components/ui/button";
import { transformSearchParams } from "@/tools/urls";
import { router, useForm, usePage } from "@inertiajs/react";
import { FormEvent, useEffect, useState } from "react";
import { SelectPort } from "./select-port";

export function FiltersGet() {
    const { url } = usePage();

    const { data, setData } = useForm({ equipament: "", port: "" });

    const handleSearch = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const params: Record<string, string | number> = {};
        const uri = url.split("?")[0];
        const currentQuery = url.split("?")[1];

        // Inserindo todos os parametros dentro do objeto params.
        new URLSearchParams(currentQuery).forEach((v, k) => (params[k] = v));

        router.get(`${uri}?${transformSearchParams({ ...params })}`);
    };

    useEffect(function () {
        const params: Record<string, string | number> = {};
        const currentQuery = url.split("?")[1];

        // Inserindo todos os parametros dentro do objeto params.
        new URLSearchParams(currentQuery).forEach((v, k) => (params[k] = v));

        if (params.equipament) {
            setData("equipament", params.equipament as string);
        }
    }, []);

    return (
        <form
            className="w-full p-4 grid grid-cols-12 gap-4"
            onSubmit={handleSearch}
        >
            <SelectEquipament
                className="col-span-12 md:col-span-2 border h-9"
                value={data.equipament}
                changeValue={(v) => setData("equipament", v)}
            />

            {data.equipament && (
                <SelectPort
                    className="col-span-12 md:col-span-2 border h-9"
                    changeValue={(v) => console.log(v)}
                    equipament={data.equipament}
                    value={data.port}
                />
            )}

            <div className="col-span-12 flex justify-end items-center">
                <Button>Filtrar</Button>
            </div>
        </form>
    );
}
