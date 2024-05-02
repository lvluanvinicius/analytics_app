import { env } from "../env";

export const setToken = (token: string) => {
    // Codificando token.
    const encodeToken = btoa(token);

    // Complemento de encode.
    const complement = `${env.VITE_API_SESSION_COMPLEMENT}`;

    // Inserindo string na sessão.
    sessionStorage.setItem(
        `${env.VITE_API_SESSION_TAG}`,
        `${complement}/${encodeToken}`,
    );
};

// Recuperando token na sessão
export const getToken = () => {
    const token = sessionStorage.getItem(`${env.VITE_API_SESSION_TAG}`);

    if (token) {
        // Separando hash do complemento.
        const tokenClean = token.split("/")[1];

        return atob(tokenClean);
    }

    return null;
};
