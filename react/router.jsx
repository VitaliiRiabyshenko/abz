import { Navigate, createBrowserRouter } from "react-router-dom";
import Users from "./src/views/Users";
import User from "./src/views/User";
import NotFound from "./src/views/NotFound";
import DefaultLayout from "./src/components/DefaultLayout";
import GuestLayout from "./src/components/GuestLayout";
import UserForm from "./src/views/UserForm";

const router = createBrowserRouter([
    {
        path: "/users/create",
        element: <DefaultLayout />,
        children: [
            {
                path: "/users/create",
                element: <UserForm key="userCreate" />,
            },
        ],
    },
    {
        path: "/",
        element: <GuestLayout />,
        children: [
            {
                path: "/",
                element: <Navigate to="/users" replace />
            },
            {
                path: "/users",
                element: <Users />,
            },
            {
                path: "/users/:id",
                element: <User />,
            },
        ],
    },
    {
        path: "*",
        element: <NotFound />,
    },
]);

export default router;
