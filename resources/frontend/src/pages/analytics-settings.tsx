import { AnalyticsSettingsLayout } from "@/components/analytics-settings/analytics-settings";
import { EquipamentsTable } from "@/components/analytics-settings/equipaments-table";
import { Padination } from "@/components/global/paginate";
import { getEquipaments } from "@/services/queries/get-equipaments";
import { useQuery } from "@tanstack/react-query";
import { Helmet } from "react-helmet-async";
import { useSearchParams } from "react-router-dom";

export function AnalyticsSettings() {
    const [searchParams, setSearchParams] = useSearchParams();

    const search = searchParams.get("search") ?? null;
    const page = searchParams.get("page") ?? "1";

    const { data: equipaments } = useQuery({
        queryFn: () => getEquipaments({ search, page }),
        queryKey: ["equipaments", search, page],
    });

    if (!equipaments) {
        return null;
    }

    function handlePaginate(pageIndex: number) {
        setSearchParams((prev) => {
            prev.set("page", pageIndex.toString());
            return prev;
        });
    }

    return (
        <div>
            <Helmet title="Analytics Configurações" />
            <AnalyticsSettingsLayout />
            <EquipamentsTable equipaments={equipaments.data} />
            <Padination
                pageIndex={equipaments.current_page}
                perPage={equipaments.per_page}
                totalCount={equipaments.total}
                onPageChange={handlePaginate}
            />
        </div>
    );
}
