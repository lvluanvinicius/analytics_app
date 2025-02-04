import DefaultLayout from "@/Layouts/admin";
import { TableEquipaments } from "./components/table-equipaments";
import { Link } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { ApiResponse } from "@/types/api";
import { EquipamentInterface } from "@/types/equipament";

export default function Equipaments({
    equipaments,
}: {
    equipaments: ApiResponse<EquipamentInterface[]>;
}) {
    if (!equipaments) return null;

    return (
        <DefaultLayout pageTitle="Equipamentos">
            <div className="flex flex-col gap-4 items-center">
                <div className="w-full md:max-w-[70vw]">
                    <div className="py-4"></div>
                    <div className="">
                        <Link href={route("app.equipaments.create")}>
                            <Button variant={"outline"} size={"sm"}>
                                + Novo Equipamento
                            </Button>
                        </Link>
                    </div>
                    <TableEquipaments equipaments={equipaments.data} />
                </div>
            </div>
        </DefaultLayout>
    );
}
