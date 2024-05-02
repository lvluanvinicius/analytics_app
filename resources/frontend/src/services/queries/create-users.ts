import { api } from "../axios";

export interface UserProps {
    email: string;
    name: string;
    username: string;
    password: string | null;
    userid: string;
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
 * @returns
 */
export async function createUsers(data: UserProps) {
    const response = await api.post("/users", data);

    if (response.data) {
        const { data } = response;

        if (data.data) {
            return data.data;
        }

        throw new Error("Contente da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados do usuários.");
}
