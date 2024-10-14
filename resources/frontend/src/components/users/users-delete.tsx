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
import { deleteUsers } from "@/services/queries/delete-users";
import { toast } from "sonner";
import { queryClient } from "@/services/react-query";

interface UsersDeleteProps {
    userId: string;
}

export function UsersDelete({ userId }: UsersDeleteProps) {
    const { mutateAsync: deleteUsersFn } = useMutation({
        mutationFn: deleteUsers,
        onSuccess(userResponse) {
            if (userResponse.status) {
                queryClient.invalidateQueries({
                    queryKey: ["users"],
                });
                toast.success(userResponse.message);
            } else {
                toast.warning(userResponse.message);
            }
        },
    });

    async function handleDelete() {
        await deleteUsersFn({ userId });
    }

    return (
        <AlertDialog>
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
    );
}
