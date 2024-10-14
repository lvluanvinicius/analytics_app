import { api } from "../axios";

export interface DeleteEquipamentsProps {
    equipamentId: string;
}

/**
 * Edita um usuário.
 * @author Luan Santos <lvluansantos@gmail.com>
 * @param {equipamentId} DeleteEquipamentsProps
 */
export async function deleteEquipaments({
    equipamentId,
}: DeleteEquipamentsProps): Promise<ActionsResponse<[]>> {
    const response = await api.delete(`/equipaments/${equipamentId}`);

    if (response.data) {
        const { data } = response;

        if (data) {
            return data;
        }

        throw new Error("Content da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados.");
}
