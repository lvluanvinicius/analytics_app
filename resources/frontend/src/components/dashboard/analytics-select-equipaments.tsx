import { getEquipaments } from "@/services/queries/get-equipaments";
import { SelectedProps, Selector } from "@/components/global/selector";
import { useState } from "react";
import { Controller, Control } from "react-hook-form";

interface AnalyticsSelectEquipamentsProps {
    control: Control<[]>;
}

export function AnalyticsSelectEquipaments({
    control,
}: AnalyticsSelectEquipamentsProps) {
    const [selectorValues, setSelectorValues] = useState<SelectedProps[]>([]);
    const [selectedValue, setSelectedValue] = useState<SelectedProps>();

    const handleSearchEquipaments = async (search: string) => {
        const response = await getEquipaments({ search });

        const auxValues: SelectedProps[] = [];

        for (let data of response.data) {
            auxValues.push({
                name: data.name,
                value: data._id,
            });
        }

        setSelectorValues(auxValues);
    };

    return (
        <Controller
            name="equipament"
            control={control}
            render={({ field: {} }) => {
                return (
                    <Selector
                        selectTitle="Selecione um Equipamentos"
                        btnTitle={selectedValue?.name ?? "Equipamentos"}
                        handleSearch={handleSearchEquipaments}
                        selectorValues={selectorValues}
                        handleSelect={(value, name) =>
                            setSelectedValue({ value, name })
                        }
                    />
                );
            }}
        />
    );
}
