import { api } from "../axios";

export interface DeleteUsersProps {
    userId: string;
}

/**
 * Edita um usuário.
 * @author Luan Santos <lvluansantos@gmail.com>
 * @param {userId} DeleteUsersProps
 */
export async function deleteUsers({
    userId,
}: DeleteUsersProps): Promise<ActionsResponse<[]>> {
    const response = await api.delete(`/users/${userId}`);

    if (response.data) {
        const { data } = response;

        if (data) {
            return data;
        }

        throw new Error("Content da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados.");
}
