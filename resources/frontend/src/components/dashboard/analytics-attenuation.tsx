import { getEquipaments } from "@/services/queries/get-equipaments";
import { SelectedProps, Selector } from "@/components/global/selector";
import { useState, useEffect } from "react";

import { AnalyticsGetPorts } from "./analytics-get-ports";
import { AnalyticsGetGponName } from "./analytics-get-gpon-names";

export function AnalyticsAattenuation() {
    const [selectorValuesEquipaments, setSelectorValuesEquipaments] = useState<
        SelectedProps[]
    >([]);
    const [selectedValueEquipament, setSelectedValueEquipament] =
        useState<SelectedProps>();

    /**
     * Recupera os equipamentos.
     * @param search
     */
    const handleSearchEquipaments = async (search: string) => {
        const response = await getEquipaments({ search });

        const auxValues: SelectedProps[] = [];

        for (let data of response.data) {
            auxValues.push({
                name: data.name,
                value: data._id,
            });
        }

        setSelectorValuesEquipaments(auxValues);
    };

    const [selectorValuesPorts, setSelectorValuesPorts] = useState<
        SelectedProps[]
    >([]);
    const [selectedValuePorts, setSelectedValuePorts] =
        useState<SelectedProps>();

    const [selectorPortsNames, setSelectorPortsNames] = useState<
        SelectedProps[]
    >([]);
    const [selectedPortName, setSelectedPortName] = useState<SelectedProps>();

    useEffect(() => {
        console.log([selectorValuesPorts, selectorPortsNames]);
    }, [selectedValueEquipament]);

    return (
        <div className="border-b pb-2">
            <form className=" flex items-center gap-4">
                <Selector
                    selectTitle="Selecione um Equipamentos"
                    btnTitle={selectedValueEquipament?.name ?? "Equipamentos"}
                    handleSearch={handleSearchEquipaments}
                    selectorValues={selectorValuesEquipaments}
                    handleSelect={(value, name) =>
                        setSelectedValueEquipament({ value, name })
                    }
                />

                <AnalyticsGetPorts
                    selectedValueEquipament={selectedValueEquipament}
                    selectorValuesPorts={selectorValuesPorts}
                    selectedValuePorts={selectedValuePorts}
                    setSelectedValuePorts={setSelectedValuePorts}
                    setSelectorValuesPorts={setSelectorValuesPorts}
                />

                <AnalyticsGetGponName
                    selectedPortName={selectedPortName}
                    setSelectedPortName={setSelectedPortName}
                    selectedValuePorts={selectedValuePorts}
                    selectorPortsNames={selectorPortsNames}
                    setSelectorPortsNames={setSelectorPortsNames}
                />
            </form>
        </div>
    );
}
