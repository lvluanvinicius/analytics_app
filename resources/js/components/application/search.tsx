import { router, usePage } from "@inertiajs/react";
import { Input } from "../ui/input";
import { FormEvent, useState } from "react";
import { transformSearchParams } from "@/tools/urls";
import { Button } from "../ui/button";

export function Search() {
    const { url } = usePage();
    const [search, setSearch] = useState<string | null>(function () {
        const params: Record<string, string | number> = {};
        const query = url.split("?")[1];
        // Inserindo todos os parametros dentro do objeto params.
        new URLSearchParams(query).forEach((v, k) => (params[k] = v));

        if (params.search) {
            return params.search as string;
        }

        return null;
    });

    const handleChangeString = (search: string) => {
        setSearch(search);
        console.log(search);
    };

    const handleSearch = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const params: Record<string, string | number> = {};
        const uri = url.split("?")[0];
        const currentQuery = url.split("?")[1];

        // Inserindo todos os parametros dentro do objeto params.
        new URLSearchParams(currentQuery).forEach((v, k) => (params[k] = v));

        if (params.search) {
            if (!search) {
                delete params.search;
            } else {
                params.search = search;
            }
        } else {
            if (search) params.search = search;
        }

        router.get(`${uri}?${transformSearchParams({ ...params })}`);
    };

    return (
        <form
            className="flex items-center gap-2 flex-1"
            onSubmit={handleSearch}
        >
            <Input
                type="search"
                placeholder="Buscar..."
                value={search || ""}
                onChange={(e) => handleChangeString(e.currentTarget.value)}
            />

            <Button type="submit">Buscar</Button>
        </form>
    );
}
