import { api } from "../axios";

export interface AppLoginParams {
    username: string
    password: string
}

export async function appLogin(data: AppLoginParams) {
    const response = await api.post('/', data)

    if (response.data) {
        return response.data
    }

    throw new Error('Erro ao tentar efetuar login, verifique os dados e tente novamente.')
}