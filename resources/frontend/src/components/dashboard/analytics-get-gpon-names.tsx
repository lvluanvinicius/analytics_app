import { toast } from "sonner";
import { SelectedProps, Selector } from "../global/selector";
import { getEquipamentsPortsNames } from "@/services/queries/get-equipaments-ports-names";

interface AnalyticsGetGponNameProps {
    selectedValuePorts: SelectedProps | undefined;
    selectedPortName: SelectedProps | undefined;
    selectorPortsNames: SelectedProps[];
    setSelectedPortName: (data: SelectedProps) => void;
    setSelectorPortsNames: (data: SelectedProps[]) => void;
}

export function AnalyticsGetGponName({
    selectedValuePorts,
    selectedPortName,
    selectorPortsNames,
    setSelectedPortName,
    setSelectorPortsNames,
}: AnalyticsGetGponNameProps) {
    const handleSearchPortsNames = async (search: string) => {
        if (!selectedValuePorts) {
            toast.error("Selecione uma porta.");
            return null;
        }

        if (!selectedPortName) {
            return null;
        }

        const response = await getEquipamentsPortsNames({
            equipament: selectedValuePorts.name.toString(),
            port: selectedValuePorts.name.toString(),
            search,
        });

        console.log(response.data);

        // const auxValues: SelectedProps[] = [];

        // for (let data of response.data) {
        //     auxValues.push({
        //         name: data.port,
        //         value: data._id,
        //     });
        // }

        // setSelectorPortsNames(auxValues);
    };

    return (
        <>
            <Selector
                btnTitle="Selecione uma conexão"
                selectTitle="Conexões (ONUs)"
                handleSearch={handleSearchPortsNames}
                selectorValues={selectorPortsNames}
                handleSelect={(value, name) =>
                    setSelectedPortName({ value, name })
                }
            />
        </>
    );
}
