import { api } from "../axios";

export interface UserProps {
    email: string;
    name: string;
    username: string;
    password: string | null;
}

export interface UserCreateResponse {
    message: string;
    status: boolean;
    type: string;
    data?: {
        user: UserProps;
        token: string;
    };
    errors?: {
        [key: string]: string;
    };
}
/**
 * Cria um novo usuário.
 * @author Luan Santos <lvluansantos@gmail.com>
 * @param data
 */
export async function createUsers(data: UserProps) {
    const response = await api.post("/users", data);

    if (response.data) {
        const { data } = response;

        if (data) {
            return data;
        }

        throw new Error("Content da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados do usuários.");
}
