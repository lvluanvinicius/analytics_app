import { createBrowserRouter } from "react-router-dom";
import { AppLayout } from "./_layouts/app";
import { Users } from "./pages/users";
import { Dashboard } from "./pages/dashboard";

export const routes = createBrowserRouter([
    {
        path: 'app/sign-in',
        element: <h1>Login</h1>
    },
    {
        path: "app/",
        element: <AppLayout />,
        children: [
            {
                path: "sign-in",
                element: <div>Login</div>
            },
            {
                path: "",
                element: <Dashboard />,
            },
            {
                path: "users/",
                element: <Users />,
            },
        ],
    },
]);
