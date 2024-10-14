import { env } from "@/env";
import axios from "axios";
import { api } from "@/services/axios";

export interface AppLoginParams {
    username: string;
    password: string;
}

export interface UserProps {
    created_at: string;
    updated_at: string;
    email: string;
    id: number;
    name: string;
    username: string;
}
export interface AppLoginResponse {
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
 * Efetua o login na API.
 * @author Luan Santos <lvluansantos@gmail.com>
 * @param {
 *  username: string
 *  password: string
 * }:AppLoginParams
 */
export async function appLogin({
    username,
    password,
}: AppLoginParams): Promise<AppLoginResponse> {
    // Gerando CSRF-TOKEN
    return await axios
        .get(`${env.VITE_API_URL}sanctum/csrf-cookie`, {
            withCredentials: true,
        })
        .then((_) => {
            return api
                .post(
                    "/sign-in",
                    {
                        username,
                        password,
                    },
                    {
                        withCredentials: true,
                    },
                )
                .then((response) => {
                    if (response.data) {
                        const { data } = response;

                        if (data) {
                            return data;
                        }

                        throw new Error(
                            "Content da requisição não encontrado.",
                        );
                    }
                })
                .catch((error) => {
                    console.error("Erro na autenticação", error.response);
                });
        });
}
