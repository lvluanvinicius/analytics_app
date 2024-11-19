import { useSearchParams } from "react-router-dom";
import { Input } from "../ui/input";
import { useForm } from "react-hook-form";
import { z } from "zod";
import { Button } from "../ui/button";

const equipamentsFilterSchema = z.object({
    search: z.string(),
});

type EquipamentsFilterTpe = z.infer<typeof equipamentsFilterSchema>;

export function EquipamentsFilter() {
    const [searchParams, setSearchParams] = useSearchParams();

    const search = searchParams.get("search") ?? null;

    const { reset, handleSubmit, register } = useForm<EquipamentsFilterTpe>({
        values: {
            search: search ?? "",
        },
    });

    async function handleFilter({ search }: EquipamentsFilterTpe) {
        setSearchParams((state) => {
            if (search) {
                state.set("search", search);
            } else {
                state.delete("search");
            }

            return state;
        });
    }

    function handleClearFilter() {
        setSearchParams((state) => {
            state.delete("search");

            return state;
        });

        reset();
    }

    return (
        <div className="flex-1">
            <form onSubmit={handleSubmit(handleFilter)} className="flex gap-4">
                <Input
                    className="w-full"
                    placeholder="Buscar por Nome, ID e Número e portas..."
                    {...register("search")}
                />
                <Button type="submit" variant={"outline"}>
                    Filtrar
                </Button>
                <Button
                    onClick={handleClearFilter}
                    type="button"
                    variant={"outline"}
                >
                    Limpar
                </Button>
            </form>
        </div>
    );
}
