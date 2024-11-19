import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogFooter,
} from "@/components/ui/dialog";
import { useState } from "react";
import { Input } from "../ui/input";
import { useForm } from "react-hook-form";
import { Button } from "../ui/button";
import { z } from "zod";
import { useMutation } from "@tanstack/react-query";
import { createEquipaments } from "@/services/queries/create-equipaments";
import { queryClient } from "@/services/react-query";
import { toast } from "sonner";

const equipamentSchema = z.object({
    name: z.string(),
    n_port: z.number().min(1),
});

type EquipamentsType = z.infer<typeof equipamentSchema>;

export function EquipamentsCreate() {
    const { register, reset, handleSubmit } = useForm<EquipamentsType>({});
    const [open, setOpen] = useState(false);

    const { mutateAsync: createEquipamentsFn } = useMutation({
        mutationFn: createEquipaments,
        onSuccess(response) {
            if (response.status) {
                setOpen(false);
                reset();
                queryClient.invalidateQueries({
                    queryKey: ["equipaments"],
                });
                toast.success(response.message);
            } else {
                toast.warning(response.message);
            }
        },
    });

    async function handleSave({ name, n_port }: EquipamentsType) {
        await createEquipamentsFn({ name, n_port });
    }

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button variant={"outline"} className="cursor-pointer">
                    Novo Equipamento
                </Button>
            </DialogTrigger>

            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Novo Equipamento</DialogTitle>
                </DialogHeader>

                <form
                    onSubmit={handleSubmit(handleSave)}
                    className="flex flex-col gap-4"
                >
                    <Input
                        type="text"
                        placeholder="Nome"
                        {...register("name", { required: true })}
                    />

                    <Input
                        type="number"
                        placeholder="Número e portas"
                        min={1}
                        {...register("n_port", { required: true })}
                    />

                    <DialogFooter>
                        <Button type="button" variant={"secondary"}>
                            Cancelar
                        </Button>
                        <Button variant={"secondary"}>Salvar</Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}
