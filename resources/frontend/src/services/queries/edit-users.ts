import { api } from "../axios";

export interface UserProps {
    id: string;
    email: string;
    name: string;
    username: string;
    password: string | null;
    updated_at?: string;
}

export interface UserEditResponse {
    message: string;
    status: boolean;
    type: string;
    data?: {
        user: UserProps;
    };
    errors?: {
        [key: string]: string;
    };
}

/**
 * Edita um usuário.
 * @author Luan Santos <lvluansantos@gmail.com>
 * @param {} UserProps
 */
export async function editUsers({
    email,
    name,
    username,
    password,
    id,
}: UserProps): Promise<UserEditResponse> {
    const response = await api.put(`/users/${id}`, {
        email,
        name,
        username,
        password,
    });

    if (response.data) {
        const { data } = response;

        if (data) {
            return data;
        }

        throw new Error("Content da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados.");
}
