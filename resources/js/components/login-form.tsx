import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { FormEventHandler } from "react";
import { useForm } from "@inertiajs/react";

export function LoginForm({
    className,
    ...props
}: React.ComponentPropsWithoutRef<"div">) {
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
        <main
            className={cn(
                "flex flex-col gap-6 fixed top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]",
                className
            )}
            {...props}
        >
            <Card>
                <CardHeader className="text-center">
                    <CardTitle className="text-xl">Analytics Api</CardTitle>
                    <CardDescription></CardDescription>
                </CardHeader>
                <CardContent>
                    <form onSubmit={submit}>
                        <div className="grid gap-6">
                            <div className="grid gap-6">
                                <div className="grid gap-2">
                                    <Label htmlFor="email">Email</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        placeholder="E-mail"
                                        value={data.email}
                                        required
                                        onChange={(e) =>
                                            setData(
                                                "email",
                                                e.currentTarget.value
                                            )
                                        }
                                    />
                                    {errors.email && <p>{errors.email}</p>}
                                </div>
                                <div className="grid gap-2">
                                    <div className="flex items-center">
                                        <Label htmlFor="password">
                                            Password
                                        </Label>
                                        <a
                                            href="#"
                                            className="ml-auto text-sm underline-offset-4 hover:underline"
                                        >
                                            Forgot your password?
                                        </a>
                                    </div>
                                    <Input
                                        id="password"
                                        type="password"
                                        required
                                        value={data.password}
                                        onChange={(e) =>
                                            setData(
                                                "password",
                                                e.currentTarget.value
                                            )
                                        }
                                    />
                                    {errors.password && (
                                        <p>{errors.password}</p>
                                    )}
                                </div>
                                <Button type="submit" className="w-full">
                                    Login
                                </Button>
                            </div>
                        </div>
                    </form>
                </CardContent>
            </Card>
            <div className="text-balance text-center text-xs text-muted-foreground [&_a]:underline [&_a]:underline-offset-4 [&_a]:hover:text-primary  ">
                By clicking continue, you agree to our{" "}
                <a href="#">Terms of Service</a> and{" "}
                <a href="#">Privacy Policy</a>.
            </div>
        </main>
    );
}
