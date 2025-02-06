import { TableEquipaments } from "./components/table-equipaments";
import { Link } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { ApiResponse } from "@/types/api";
import { EquipamentInterface } from "@/types/equipament";
import { TablePaginate } from "@/components/application/table-paginate";
import { Search } from "@/components/application/search";
import AppPageHandler from "@/components/application/_page_handler";

export default function Equipaments({
    equipaments,
}: {
    equipaments: ApiResponse<EquipamentInterface[]>;
}) {
    if (!equipaments) return null;

    return (
        <AppPageHandler
            pageTitle="Equipamentos"
            actions={
                <div className="flex items-center gap-2 md:flex-1">
                    <Search />

                    <Link href={route("app.equipaments.create")}>
                        <Button variant={"outline"}>+ Novo Equipamento</Button>
                    </Link>
                </div>
            }
        >
            <div className="flex items-center gap-2 mt-4"></div>

            <TableEquipaments equipaments={equipaments.data} />

            <TablePaginate paginate={equipaments} />
        </AppPageHandler>
    );
}
