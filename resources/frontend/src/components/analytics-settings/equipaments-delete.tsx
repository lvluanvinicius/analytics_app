import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/components/ui/alert-dialog";
import { Button } from "../ui/button";
import { Trash2 } from "lucide-react";
import { useMutation } from "@tanstack/react-query";
import { toast } from "sonner";
import { queryClient } from "@/services/react-query";
import { deleteEquipaments } from "@/services/queries/delete-equipaments";

interface DeleteEquipamentsProps {
    equipamentId: string;
}

export function DeleteEquipaments({ equipamentId }: DeleteEquipamentsProps) {
    const { mutateAsync: deleteEquipamentsFn } = useMutation({
        mutationFn: deleteEquipaments,
        onSuccess(response) {
            if (response.status) {
                queryClient.invalidateQueries({
                    queryKey: ["equipaments"],
                });
                toast.success(response.message);
            } else {
                toast.warning(response.message);
            }
        },
    });

    async function handleDelete() {
        await deleteEquipamentsFn({ equipamentId });
    }

    return<AlertDialog>
    <AlertDialogTrigger asChild>
        <Button variant={"destructive"} size={"sm"}>
            <Trash2 size={16} />
        </Button>
    </AlertDialogTrigger>

    <AlertDialogContent>
        <AlertDialogHeader>
            <AlertDialogTitle>
                Deseja realmente excluír o usuário?
            </AlertDialogTitle>
            <AlertDialogDescription className="">
                Ao efetuar a exclusão desse usuário, podera causar
                algumas nconsistências em seus dados, não podendo mais
                acessar devido a perca do seu índice.
            </AlertDialogDescription>

            <AlertDialogFooter>
                <AlertDialogCancel>Cancelar</AlertDialogCancel>
                <AlertDialogAction onClick={handleDelete}>
                    Confirmar
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogHeader>
    </AlertDialogContent>
</AlertDialog>
}
