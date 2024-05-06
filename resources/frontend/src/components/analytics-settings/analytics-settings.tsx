import { EquipamentsCreate } from "./equipaments-create";
import { EquipamentsFilter } from "./equipaments-filter";

export function AnalyticsSettingsLayout() {
    return (
        <div className="flex items-center gap-4 border-b pb-2">
            <EquipamentsCreate />
            <EquipamentsFilter />
        </div>
    );
}
