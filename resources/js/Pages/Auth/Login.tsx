import { useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { SignInLayout } from "@/Layouts/sign-in";
import { LoginForm } from "@/components/login-form";

export default function Login({
    status,
    canResetPassword,
}: {
    status?: string;
    canResetPassword: boolean;
}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false as boolean,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route("login"), {
            onFinish: () => reset("password"),
        });
    };

    return (
        <SignInLayout>
            <LoginForm />
        </SignInLayout>
    );
}
