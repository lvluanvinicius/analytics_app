import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogFooter,
} from "@/components/ui/dialog";
import { useState } from "react";
import { Button } from "../ui/button";
import { Input } from "../ui/input";
import { z } from "zod";
import { useForm } from "react-hook-form";
import { useMutation } from "@tanstack/react-query";
import { editUsers, UserProps } from "@/services/queries/edit-users";
import { queryClient } from "@/services/react-query";
import { toast } from "sonner";

interface UsersEditProps {
    user: UserProps;
}

const userSchema = z.object({
    username: z.string(),
    password: z.string().min(8).nullable(),
    name: z.string(),
    email: z.string().email(),
});

type UserTypeSchema = z.infer<typeof userSchema>;

export function UsersEdit({ user }: UsersEditProps) {
    const [open, setOpen] = useState(false);

    const { handleSubmit, register } = useForm<UserTypeSchema>({
        values: {
            name: user.name,
            username: user.username,
            email: user.email,
            password: "",
        },
    });

    const { mutateAsync: editUserFn } = useMutation({
        mutationFn: editUsers,
        onSuccess(userResponse) {
            // if (userResponse.data) {
            //     const { data } = userResponse;

            //     const userList = queryClient.getQueriesData<
            //         ApiResponse<UserProps[]>
            //     >({
            //         queryKey: ["users"],
            //     });

            //     userList.forEach(([cacheKey, cached]) => {
            //         if (!cached) {
            //             return;
            //         }

            //         console.log(cached);

            //         queryClient.setQueryData<ApiResponse<UserProps[]>>(
            //             cacheKey,
            //             {
            //                 ...cached,
            //                 data: cached.data.map((usr) => {
            //                     if (usr.id === user.id) {
            //                         return {
            //                             ...usr,
            //                             name: data.user.name,
            //                             email: data.user.email,
            //                             username: data.user.username,
            //                             updated_at: data.user.updated_at,
            //                         };
            //                     }

            //                     return user;
            //                 }),
            //             },
            //         );
            //     });
            // }

            if (userResponse.status) {
                setOpen(false);
                queryClient.invalidateQueries({
                    queryKey: ["users"],
                });
                toast.success(userResponse.message);
            } else {
                toast.warning(userResponse.message);
            }
        },
        onError(error) {
            console.log(error);
        },
    });

    async function handleSaveUser({
        username,
        password,
        name,
        email,
    }: UserTypeSchema) {
        await editUserFn({
            username,
            password,
            name,
            email,
            id: user.id,
        });
    }

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button variant={"outline"} className="h-8">
                    Editar
                </Button>
            </DialogTrigger>

            <DialogContent className="pb-10">
                <DialogHeader>
                    <DialogTitle>Editar {user.name}</DialogTitle>
                    <DialogDescription>Edição de Usuário</DialogDescription>
                </DialogHeader>

                <form
                    onSubmit={handleSubmit(handleSaveUser)}
                    className="flex flex-col gap-4"
                >
                    <Input
                        {...register("name", { required: true })}
                        type="text"
                        placeholder="Nome"
                    />
                    <Input
                        {...register("username", { required: true })}
                        type="text"
                        placeholder="Usuário"
                    />
                    <Input
                        {...register("email", { required: true })}
                        type="email"
                        placeholder="E-mail"
                    />
                    <Input
                        {...register("password", { required: false })}
                        type="password"
                        placeholder="Senha"
                    />

                    <DialogFooter>
                        <Button
                            variant="secondary"
                            className="w-full text-[1rem]"
                        >
                            Atualizar
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}
