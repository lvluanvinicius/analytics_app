import { TableEquipamentPorts } from "./components/table-ports";
import { ApiResponse } from "@/types/api";
import { TablePaginate } from "@/components/application/table-paginate";
import { Search } from "@/components/application/search";
import AppPageHandler from "@/components/application/_page_handler";
import { EquipamentPortInterface } from "@/types/equipament-port";

export default function Ports({
    ports,
}: {
    ports: ApiResponse<EquipamentPortInterface[]>;
}) {
    if (!ports) return null;

    return (
        <AppPageHandler pageTitle="Portas" widthTotal>
            <div className="bg-sidebar p-8">
                <div className="flex items-center gap-2 md:flex-1 mb-4">
                    <Search />
                </div>

                <TableEquipamentPorts ports={ports.data} />

                <TablePaginate paginate={ports} />
            </div>
        </AppPageHandler>
    );
}
