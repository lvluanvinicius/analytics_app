import { env } from "@/env";
import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export async function csrfCookie() {
    try {
        return await axios.get(`${env.VITE_API_URL}sanctum/csrf-cookie`)
    } catch (error) {
        throw new Error('Erro ao tentar configurar CSRF Token. Por favor, tente novamente mais tarde.');
    }
}