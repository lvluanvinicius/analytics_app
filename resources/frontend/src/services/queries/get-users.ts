import { api } from "../axios";

export interface getUsersParams {
    search: string
}

export async function getUsers({search}: getUsersParams) {
    const response = await api.get('/users', {
        params: {
            search
        }
    })

    if (response.data) {
        return response.data
    }

    throw new Error('Erro ao tentar recuperar os dados do usuários.')
}