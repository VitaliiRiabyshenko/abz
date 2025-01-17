import React, { useEffect } from "react";
import { Outlet } from "react-router-dom";
import { userStateContext } from "../contexts/ContextProvider";
import axiosClient from "../axios-client";

const DefaultLayout = () => {
    const { token, notification, setToken } = userStateContext();

    useEffect(() => {
        getToken();
    }, []);

    const getToken = () => {
        axiosClient
            .get("/token")
            .then(({ data }) => {
                setToken(data.token);
            })
            .catch();
    };

    return (
        <div id="defaultLayout">
            <div className="content">
                <main>
                    <Outlet />
                </main>
                {notification && (
                    <div className="notification">{notification}</div>
                )}
            </div>
        </div>
    );
};

export default DefaultLayout;
