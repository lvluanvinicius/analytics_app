import { env } from "@/env";
import axios from "axios";
import { toast } from "sonner";

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

export async function appLogin({
    username,
    password,
}: AppLoginParams): Promise<AppLoginResponse> {
    // Efetuando requisição de login.
    const response = await axios.post<AppLoginResponse>(
        `${env.VITE_API_URL}api/analytics/login`,
        {
            username,
            password,
        },
        {
            headers: {
                Accept: "application/json",
            },
        },
    );

    if (response.data && response.data.data) {
        return response.data;
    } else {
        toast.error(response.data.message);
        return response.data;
    }
}
