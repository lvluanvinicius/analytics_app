import { api } from "@/services/axios";

export interface EquipamentsProps {
    created_at: string;
    updated_at: string;
    id: string;
    name: string;
    n_port: number;
}

export interface EquipamentsParams {
    search: string | null;
    page?: string | null;
}

export async function getEquipaments({
    search,
    page,
}: EquipamentsParams): Promise<ApiResponse<EquipamentsProps[]>> {
    const response = await api.get("/equipaments", {
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
