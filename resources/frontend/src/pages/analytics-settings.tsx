import { AnalyticsSettingsLayout } from "@/components/analytics-settings/analytics-settings";
import { EquipamentsPaginate } from "@/components/analytics-settings/equipaments-paginate";
import { EquipamentsTable } from "@/components/analytics-settings/equipaments-table";
import { getEquipaments } from "@/services/queries/get-equipaments";
import { useQuery } from "@tanstack/react-query";
import { Helmet } from "react-helmet-async";
import { useSearchParams } from "react-router-dom";

export function AnalyticsSettings() {
    const [searchParams] = useSearchParams();

    const search = searchParams.get("search") ?? null;
    const page = searchParams.get("page") ?? null;

    const { data: equipaments } = useQuery({
        queryFn: () => getEquipaments({ search, page }),
        queryKey: ["equipaments", search, page],
    });

    if (!equipaments) {
        return null;
    }

    return (
        <div>
            <Helmet title="Analytics Configurações" />
            <AnalyticsSettingsLayout />
            <EquipamentsTable equipaments={equipaments.data} />
            <EquipamentsPaginate />
        </div>
    );
}
