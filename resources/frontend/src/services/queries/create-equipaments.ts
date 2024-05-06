import { api } from "../axios";

export interface EquipamentsProps {
    name: string;
    n_port: number;
}
/**
 * Cria um novo usuário.
 * @author Luan Santos <lvluansantos@gmail.com>
 * @param data
 */
export async function createEquipaments(
    data: EquipamentsProps,
): Promise<ActionsResponse<[]>> {
    const response = await api.post<ActionsResponse<[]>>("/equipaments", data);

    if (response.data) {
        const { data } = response;

        if (data) {
            return data;
        }

        throw new Error("Content da requisição não encontrado.");
    }

    throw new Error("Erro ao tentar recuperar os dados do usuários.");
}
