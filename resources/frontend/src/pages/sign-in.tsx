import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { env } from "@/env";
import { appLogin, AppLoginParams } from "@/services/queries/app-login";
import { useMutation } from "@tanstack/react-query";
import { useForm } from "react-hook-form";
import { z } from "zod";

const signInSchema = z.object({
    username: z.string(),
    password: z.string().min(8),
});

type SignInType = z.infer<typeof signInSchema>;

export function SignIn() {
    const { handleSubmit, register } = useForm<SignInType>({
        values: { username: "luan1", password: "teste1" },
    });

    const { mutateAsync: appLoginFn, data: responseData } = useMutation({
        mutationFn: appLogin,
    });

    async function handleAppLogin({ username, password }: AppLoginParams) {
        try {
            await appLoginFn({ username, password });
        } catch (error) {}
    }

    return (
        <div className="flex min-h-screen items-center justify-center">
            <div className="flex min-h-[380px] min-w-[330px] flex-col items-center justify-center rounded-md border px-8 py-4 shadow-sm dark:shadow-white/20">
                <div className="mb-4">
                    <h1 className="text-[1.5rem] font-bold">
                        {env.VITE_APP_NAME}
                    </h1>
                </div>
                <form
                    onSubmit={handleSubmit(handleAppLogin)}
                    className="flex h-full w-full flex-col gap-4"
                >
                    <Input
                        type="username"
                        placeholder="Usuário..."
                        {...register("username", { required: true })}
                    />
                    <Input
                        type="password"
                        placeholder="Senha..."
                        {...register("password", { required: true })}
                    />

                    <Button>Sign In</Button>
                </form>
            </div>
        </div>
    );
}
