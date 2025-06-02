import { Head } from "@inertiajs/react";
import { Form } from "./form";

export default function Index({ flash }: { flash: { error: null | string } }) {
    return (
        <>
            <Head title="Login" />
            <Form error={flash.error} />
        </>
    );
}
