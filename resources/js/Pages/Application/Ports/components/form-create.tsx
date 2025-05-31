import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useForm } from "@inertiajs/react";
import { FormEvent } from "react";

export function FormCreate() {
    const { data, setData, errors, post, processing } = useForm({
        name: "",
        n_port: "",
    });

    function handleSubmit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();

        post(route("app.equipaments.store"));
    }

    return (
        <form onSubmit={handleSubmit} className="flex flex-col gap-4 mt-4">
            <Label className="flex flex-col gap-2">
                <span className="text-muted-foreground">
                    Nome para Equipamento
                </span>
                <Input
                    className="h-10"
                    value={data.name}
                    onChange={(e) => setData("name", e.currentTarget.value)}
                />
                {errors.name && (
                    <p className="text-red-500 text-sm">{errors.name}</p>
                )}
            </Label>

            <Label className="flex flex-col gap-2">
                <span className="text-muted-foreground">Número de Portas</span>
                <Input
                    className="h-10"
                    type="number"
                    value={data.n_port}
                    onChange={(e) => setData("n_port", e.currentTarget.value)}
                />
                {errors.n_port && (
                    <p className="text-red-500 text-sm">{errors.n_port}</p>
                )}
            </Label>

            <Button>Criar</Button>
        </form>
    );
}
