import { env } from "@/env";
import { api } from "./axios";

export async function csrfCookie() {
    try {
        return await api.get(`${env.VITE_API_URL}sanctum/csrf-cookie`);
    } catch (error) {
        throw new Error(
            "Erro ao tentar configurar CSRF Token. Por favor, tente novamente mais tarde.",
        );
    }
}
