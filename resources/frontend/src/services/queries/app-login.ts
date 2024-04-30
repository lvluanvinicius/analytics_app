import { api } from "../axios";
import { csrfCookie } from "../csrf-cookie";

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
    data?: UserProps;
    errors?: {
        [key: string]: string;
    };
}

export async function appLogin({ username, password }: AppLoginParams) {
    return await csrfCookie().then(async () => {
        // Efetuando requisição de login.
        const response = await api.post<AppLoginResponse>("/login", {
            username,
            password,
        });

        if (response.data && response.data.status) {
            return response.data;
        } else {
            throw new Error(response.data.message);
        }
    });
}
