import { z } from "zod";

const envSchema = z.object({
    VITE_API_URL: z.string().url(),
    VITE_APP_NAME: z.string(),
    VITE_API_SESSION_TAG: z.string(),
    VITE_API_SESSION_COMPLEMENT: z.string(),
});

export const env = envSchema.parse(import.meta.env);
