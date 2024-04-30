import { createBrowserRouter } from "react-router-dom";
import { AppLayout } from "./_layouts/app";
import { Users } from "./pages/users";
import { Dashboard } from "./pages/dashboard";
import { SignInLayout } from "./_layouts/sign-in";
import { SignIn } from "./pages/sign-in";

export const routes = createBrowserRouter([
    {
        path: "app/sign-in",
        element: <SignInLayout />,
        children: [
            {
                path: "",
                element: <SignIn />,
            },
        ],
    },
    {
        path: "app/",
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
        ],
    },
]);
