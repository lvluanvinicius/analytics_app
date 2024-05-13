import { api } from "@/services/axios";

export interface EquipamentsPortsNamesParams {
    search: string | null;
    page?: string | null;
    equipament: string;
    port: string;
}

export async function getEquipamentsPortsNames({
    search,
    page,
    equipament,
    port,
}: EquipamentsPortsNamesParams): Promise<ApiResponse<String[]>> {
    const response = await api.get("/equipaments", {
        params: {
            search: search ?? null,
            page: page ?? null,
            equipament,
            port,
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
