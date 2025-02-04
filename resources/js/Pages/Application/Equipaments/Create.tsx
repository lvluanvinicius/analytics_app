import DefaultLayout from "@/Layouts/admin";
import { FormCreate } from "./components/form-create";

export default function Create() {
    return (
        <DefaultLayout pageTitle="Novo Equipamentos">
            <div className=" flex justify-center">
                <div className="w-full md:max-w-[60vw]">
                    <div>
                        <h1>Novo Equipamento</h1>
                    </div>

                    <FormCreate />
                </div>
            </div>
        </DefaultLayout>
    );
}
