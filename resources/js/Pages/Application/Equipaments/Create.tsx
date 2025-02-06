import { FormCreate } from "./components/form-create";
import AppPageHandler from "@/components/application/_page_handler";

export default function Create() {
    return (
        <AppPageHandler pageTitle="Novo Equipamento" heading="Novo Equipamento">
            <FormCreate />
        </AppPageHandler>
    );
}
