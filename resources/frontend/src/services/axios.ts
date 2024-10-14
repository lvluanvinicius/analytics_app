import axios from "axios";

import { env } from "@/env";

// Recuperando token na sessão.

export const api = axios.create({
    baseURL: `${env.VITE_API_URL}api/analytics`,
    headers: {
        Accept: "application/json",
        common: {
            Accept: "application/json",
        },
    },
    withCredentials: true,
    withXSRFToken: true,
});
