import { Button } from "@/components/ui/button";
import { useForm } from "@inertiajs/react";
import { Trash } from "lucide-react";

export function Delete({ equipament }: { equipament: string }) {
    const { delete: deleteFn } = useForm();

    const handleDelete = () => {
        if (confirm("Deseja realmente excluír esse equipamento?")) {
            deleteFn(route("app.equipaments.destroy", equipament));
        }
    };

    return (
        <Button variant={"destructive"} size={"icon"} onClick={handleDelete}>
            <Trash />
        </Button>
    );
}
