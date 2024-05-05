import { api } from "../axios";

export interface EquipamentsProps {
    created_at: string;
    updated_at: string;
    _id: string;
    name: string;
    n_port: number;
}

export async function getUsers({
    search,
}: any): Promise<ApiResponse<EquipamentsProps[]>> {
    const response = await api.get("/equipaments", {
        params: {
            search: search ?? null,
        },
    });

    if (response.data) {
        const { data } = response;

        if (data.data) {
            return data;
        }

        throw new Error("Content da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados do usuários.");
}
