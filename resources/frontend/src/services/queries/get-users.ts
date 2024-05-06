import { api } from "../axios";

export interface getUsersParams {
    search: string | null;
    page: string | number;
}

export interface UserProps {
    created_at: string;
    updated_at: string;
    email: string;
    id: string;
    name: string;
    username: string;
}

export async function getUsers({
    search,
    page,
}: getUsersParams): Promise<ApiResponse<UserProps[]>> {
    const response = await api.get("/users", {
        params: {
            search: search ?? null,
            page,
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
