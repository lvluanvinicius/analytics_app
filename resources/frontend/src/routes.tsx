import { createBrowserRouter } from "react-router-dom";
import { AppLayout } from "./_layouts/app";
import { Users } from "./pages/users";
import { Dashboard } from "./pages/dashboard";
import { SignInLayout } from "./_layouts/sign-in";
import { SignIn } from "./pages/sign-in";
import { AnalyticsSettings } from "./pages/analytics-settings";

export const routes = createBrowserRouter([
    {
        path: "sign-in",
        element: <SignInLayout />,
        children: [
            {
                path: "",
                element: <SignIn />,
            },
        ],
    },
    {
        path: "",
        element: <AppLayout />,
        children: [
            {
                path: "sign-in",
                element: <div>Login</div>,
            },
            {
                path: "",
                element: <Dashboard />,
            },
            {
                path: "users/",
                element: <Users />,
            },
            {
                path: "analytics-settings/",
                element: <AnalyticsSettings />,
            },
        ],
    },
]);
