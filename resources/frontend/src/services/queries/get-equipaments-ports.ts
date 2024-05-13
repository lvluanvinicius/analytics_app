import { api } from "../axios";

export interface EquipamentsPortsProps {
    _id: string;
    port: string;
    equipament_id: string;
}

export interface EquipamentsPortsParams {
    search?: string | null;
    page?: string | null;
    equipament?: string;
}

export async function getEquipamentsAllPorts({
    equipament,
}: EquipamentsPortsParams): Promise<ApiResponse<EquipamentsPortsProps[]>> {
    const response = await api.get<ApiResponse<EquipamentsPortsProps[]>>(
        `/ports/all/${equipament}`,
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

export async function getEquipamentsPorts({
    search,
    page,
    equipament,
}: EquipamentsPortsParams): Promise<ApiResponse<EquipamentsPortsProps[]>> {
    const response = await api.get(`ports/${equipament}`, {
        params: {
            search: search ?? null,
            page: page ?? null,
        },
    });

    if (response.data) {
        const { data } = response;

        if (data.data) {
            return data.data;
        }

        throw new Error("Content da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados.");
}
