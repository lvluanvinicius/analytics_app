import axios from "axios";

import { env } from "@/env";
import { getToken } from "./token";

// Recuperando token na sessão.
const token = getToken();

export const api = axios.create({
    baseURL: env.VITE_API_URL + "api/analytics/",
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        Authorization: token ? `Bearer ${token}` : null,
    },
    withCredentials: true,
    withXSRFToken: true,
});
