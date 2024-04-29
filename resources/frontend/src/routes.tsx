import { createBrowserRouter } from "react-router-dom";
import { AppLayout } from "./_layouts/app";
import { Users } from "./pages/users";
import { Dashboard } from "./pages/dashboard";

export const routes = createBrowserRouter([
    {
        path: "app/",
        element: <AppLayout />,
        children: [
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
