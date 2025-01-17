import { createContext, useContext, useState } from "react";

const StateContext = createContext({
    notification: null
});

export const GuestContextProvider = ({ children }) => {
    const [notification, _setNotification] = useState("");

    const setNotification = (message) => {
        _setNotification(message);
        setTimeout(() => {
            _setNotification("");
        }, 5000);
    };

    return (
        <StateContext.Provider
            value={{
                notification,
                setNotification,
            }}
        >
            {children}
        </StateContext.Provider>
    );
};

export const userStateContext = () => useContext(StateContext);
