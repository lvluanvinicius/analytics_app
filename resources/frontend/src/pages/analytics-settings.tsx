import { AnalyticsSettingsLayout } from "@/components/analytics-settings/analytics-settings";
import { EquipamentsTable } from "@/components/analytics-settings/equipaments-table";
import { Helmet } from "react-helmet-async";

export function AnalyticsSettings() {
    return (
        <div>
            <Helmet title="Analytics Configurações" />
            <AnalyticsSettingsLayout />
            <EquipamentsTable />
        </div>
    );
}
