import { usePage } from "@inertiajs/react";
import { ReactNode } from "react";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { AlertCircle, CircleCheck } from "lucide-react";
import DefaultLayout from "@/Layouts/admin";
import { cn } from "@/lib/utils";

interface ClientPageHandlerProps {
    heading?: string;
    pageTitle?: string;
    actions?: ReactNode;
    children: ReactNode;
    widthTotal?: boolean;
}

export default function AppPageHandler({
    heading,
    pageTitle,
    actions,
    children,
    widthTotal,
}: ClientPageHandlerProps) {
    const { flash } = usePage().props;
    const responseMessage = flash as {
        success?: string;
        error?: string;
    };

    return (
        <>
            <DefaultLayout pageTitle={pageTitle}>
                <div className="mt-4 w-full flex justify-center max-w-[95vw]">
                    <div
                        className={cn(
                            "w-full md:max-w-[70vw]",
                            widthTotal && "md:!max-w-[100%]"
                        )}
                    >
                        {responseMessage && (
                            <>
                                {responseMessage.error && (
                                    <Alert
                                        variant="destructive"
                                        className="my-4"
                                    >
                                        <AlertCircle className="h-4 w-4" />
                                        <AlertTitle>Ooops!</AlertTitle>
                                        <AlertDescription>
                                            {responseMessage.error}
                                        </AlertDescription>
                                    </Alert>
                                )}
                                {responseMessage.success && (
                                    <Alert variant="success" className="my-4">
                                        <CircleCheck className="h-4 w-4 !text-green-500" />
                                        <AlertTitle>Sucesso!</AlertTitle>
                                        <AlertDescription>
                                            {responseMessage.success}
                                        </AlertDescription>
                                    </Alert>
                                )}
                            </>
                        )}

                        {heading ? (
                            <div className="flex items-end justify-between border-b pb-2">
                                <h1 className="text-xl font-bold">{heading}</h1>
                                {actions ? actions : ""}
                            </div>
                        ) : actions ? (
                            <div className="flex items-end justify-between border-b pb-2">
                                {actions}
                            </div>
                        ) : (
                            ""
                        )}

                        <main className="flex flex-col gap-4">{children}</main>
                    </div>
                </div>
            </DefaultLayout>
        </>
    );
}
