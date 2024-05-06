import { api } from "../axios";

export interface EquipamentsPortsProps {
    port: string;
    _id: string;
}

export interface EquipamentsPortsParams {
    equipament: string;
}

export async function getEquipamentsPorts({
    equipament,
}: EquipamentsPortsParams): Promise<ApiResponse<EquipamentsPortsProps[]>> {
    const response = await api.get<ApiResponse<EquipamentsPortsProps[]>>(
        `/ports/${equipament}`,
    );

    if (response.data) {
        const { data } = response;

        if (data.data) {
            return data;
        }

        throw new Error("Content da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados.");
}
