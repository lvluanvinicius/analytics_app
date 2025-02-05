import DefaultLayout from "@/Layouts/admin";
import { GraphOnuDBM } from "./components/graph-onu-dbm";
import { FiltersGet } from "./components/filters";

export default function OnuInventory() {
    return (
        <DefaultLayout pageTitle="ONU Inventory">
            <div className="flex flex-col gap-4 ">
                <FiltersGet />
                <GraphOnuDBM />
            </div>
        </DefaultLayout>
    );
}
