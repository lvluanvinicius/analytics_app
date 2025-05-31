import DefaultLayout from "@/Layouts/admin";
import { GraphOnuDBM } from "./components/graph-onu-dbm";
import { FiltersGet } from "./components/filters";
import { GPonOnusDBMInterface } from "@/types/onu-names";
import { TableDetails } from "./components/table-details";

export default function OnuInventory({
    records,
}: {
    records: GPonOnusDBMInterface[];
}) {
    return (
        <DefaultLayout pageTitle="ONU Inventory">
            <div className="flex flex-col gap-4">
                <FiltersGet />
                <GraphOnuDBM collections={records} />
                <TableDetails />
            </div>
        </DefaultLayout>
    );
}
