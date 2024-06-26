import { Helmet, HelmetProvider } from "react-helmet-async";
import { Toaster } from "sonner";
import { ThemeProvider } from "@/components/themes/theme-provider";
import { QueryClientProvider } from "@tanstack/react-query";
import { queryClient } from "@/services/react-query";
import { RouterProvider } from "react-router-dom";
import { routes } from "@/routes";
import { env } from "./env";

export function App() {
    return (
        <HelmetProvider>
            <ThemeProvider storageKey="analytics-theme" defaultTheme="system">
                <Toaster richColors closeButton />
                <Helmet titleTemplate={`%s | ${env.VITE_APP_NAME}`} />
                <QueryClientProvider client={queryClient}>
                    <RouterProvider router={routes} />
                </QueryClientProvider>
            </ThemeProvider>
        </HelmetProvider>
    );
}
