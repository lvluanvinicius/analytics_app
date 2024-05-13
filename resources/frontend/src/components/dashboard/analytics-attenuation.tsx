import { getEquipaments } from "@/services/queries/get-equipaments";
import { SelectedProps, Selector } from "@/components/global/selector";
import { useState } from "react";
import {} from "react";
import { getEquipamentsPorts } from "@/services/queries/get-equipaments-ports";
import { toast } from "sonner";
import { getEquipamentsPortsNames } from "@/services/queries/get-equipaments-ports-names";

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
        handleGetPortsNames("");
    };

    const handleGetPortsNames = async (search: string) => {
        if (!selectedValueEquipament) {
            toast.error("Selecione um equipamento.");
            return null;
        }

        if (!selectedValuePorts) {
            toast.error("Selecione uma porta.");
            return null;
        }

        const response = await getEquipamentsPortsNames({
            search,
            equipament: selectedValueEquipament.name.toString(),
            port: selectedValuePorts.name.toString(),
        });

        console.log(response.data);

        // const auxValues: SelectedProps[] = [];

        // for (let data of response.data) {
        //     auxValues.push({
        //         name: data.port,
        //         value: data._id,
        //     });
        // }

        // setSelectorValuesPorts(auxValues);
    };

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

                <Selector
                    selectTitle="Selecione uma porta"
                    btnTitle={selectedValuePorts?.name ?? "Portas"}
                    handleSearch={handleSearchPorts}
                    selectorValues={selectorValuesPorts}
                    handleSelect={(value, name) =>
                        setSelectedValuePorts({ value, name })
                    }
                />
            </form>
        </div>
    );
}
