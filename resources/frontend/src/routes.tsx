import { createBrowserRouter } from 'react-router-dom'
import { AppLayout } from './_layouts/app'

export const routes = createBrowserRouter([
    {
        path: "app/",
        element: <AppLayout/>,
        children: []
    }
])