import { toast } from "sonner";
import { SelectedProps, Selector } from "../global/selector";

import { getEquipamentsPorts } from "@/services/queries/get-equipaments-ports";

interface AnalyticsGetPortsProps {
    selectedValueEquipament: SelectedProps | undefined;
    selectedValuePorts: SelectedProps | undefined;
    selectorValuesPorts: SelectedProps[];
    setSelectorValuesPorts: (data: SelectedProps[]) => void;
    setSelectedValuePorts: (data: SelectedProps) => void;
}

export function AnalyticsGetPorts({
    selectedValueEquipament,
    selectedValuePorts,
    setSelectorValuesPorts,
    selectorValuesPorts,
    setSelectedValuePorts,
}: AnalyticsGetPortsProps) {
    /**
     * Recupera as portas.
     * @param search
     */
    const handleSearchPorts = async (search: string) => {
        if (!selectedValueEquipament) {
            toast.error("Selecione um equipamento.");
            return null;
        }

        const response = await getEquipamentsPorts({
            equipament: selectedValueEquipament.name.toString(),
            search,
        });

        const auxValues: SelectedProps[] = [];

        for (let data of response.data) {
            auxValues.push({
                name: data.port,
                value: data._id,
            });
        }

        setSelectorValuesPorts(auxValues);
    };

    return (
        <>
            <Selector
                selectTitle="Selecione uma porta"
                btnTitle={selectedValuePorts?.name ?? "Portas"}
                handleSearch={handleSearchPorts}
                selectorValues={selectorValuesPorts}
                handleSelect={(value, name) =>
                    setSelectedValuePorts({ value, name })
                }
            />
        </>
    );
}
