import { useSearchParams } from "react-router-dom";
import { Button } from "../ui/button";
import { Input } from "../ui/input";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { UsersCreate } from "./users-create";

const searchFilter = z.object({
    search: z.string().optional(),
});

type SearchFilterType = z.infer<typeof searchFilter>;

export function UsersFilter() {
    const [searchParams, setSearchParams] = useSearchParams();

    // Recuperando valor do paramaetro de 'search';
    const search = searchParams.get("search") ?? null;

    const { handleSubmit, register, reset } = useForm<SearchFilterType>({
        values: {
            search: search ?? "",
        },
    });

    // Adicionando/removendo parametro search das query params.
    function handleSearchString(data: SearchFilterType) {
        setSearchParams((state) => {
            // Valida se há um valor em search e adiciona dentro dos parametros.
            if (data.search) {
                state.set("search", data.search);
            } else {
                // Remove se não for informado nenhum valor.
                state.delete("search");
            }

            return state;
        });
    }

    function clearFilter() {
        setSearchParams((state) => {
            state.delete("search");
            state.delete("page");

            reset({
                search: "",
            });

            return state;
        });
    }

    return (
        <div className="mb-2 w-full ">
            <form
                className="flex w-full gap-2"
                onSubmit={handleSubmit(handleSearchString)}
            >
                <Input
                    placeholder="Buscar usuário"
                    className="flex-1"
                    {...register("search")}
                />
                <Button variant="outline" type="submit">
                    Filtrar
                </Button>
                <Button variant="outline" type="button" onClick={clearFilter}>
                    Limpar Filtro
                </Button>

                <UsersCreate />
            </form>
        </div>
    );
}
