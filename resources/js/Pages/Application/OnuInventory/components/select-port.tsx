import { application } from "@/services/app";
import { ActionsResponse } from "@/types/api";
import { EquipamentPortInterface } from "@/types/equipament-port";
import { useQuery } from "@tanstack/react-query";

export function SelectPort({
    equipament,
    value,
    changeValue,
    className,
    loadData,
}: {
    equipament: string;
    value: string;
    changeValue: (value: string) => void;
    className?: string;
    loadData?: EquipamentPortInterface;
}) {
    const { data: ports } = useQuery({
        queryKey: ["equipament-ports"],
        queryFn: async function () {
            const response = await application.get<
                ActionsResponse<EquipamentPortInterface[]>
            >(`/equipament/${equipament}/ports`);

            if (response.data) {
                return response.data.data;
            }

            return null;
        },
        // enabled: !!open,
    });

    console.log(ports);

    return <></>;
}
