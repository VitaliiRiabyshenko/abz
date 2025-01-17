import React from "react";
import { Outlet } from "react-router-dom";
import { userStateContext } from "../contexts/ContextProvider";

const GuestLayout = () => {
    const { notification } = userStateContext();

    return (
        <div className="login-signup-form animated fadeInDown">
            {notification && (
                    <div className="notification">{notification}</div>
                )}
            <div className="form">
                <main>
                    <Outlet />
                </main>                
            </div>
        </div>
    );
};

export default GuestLayout;
