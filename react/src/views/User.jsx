import React, { useEffect, useState } from "react";
import axiosClient from "../axios-client";
import { useParams } from "react-router-dom";
import { userStateContext } from "../contexts/ContextProvider";

const User = () => {
    const [user, setUser] = useState({});
    const { id } = useParams();
    const { setNotification } = userStateContext();
    const [errors, setErrors] = useState(null);

    useEffect(() => {
        getUser();
    }, []);

    const getUser = () => {
        axiosClient
            .get(`/users/${id}`)
            .then(({ data }) => {
                console.log(data.user);
                setUser(data.user);
            })
            .catch((err) => {
                setNotification(err.response.data.message);
                const response = err.response;
                if (
                    response &&
                    (response.status === 400 || response.status === 404)
                ) {
                    if (response.data.fails) {
                        console.log(response.data.fails);
                        setErrors(response.data.fails);
                    }
                }
            });
    };

    return (
        <div>
            <div
                style={{
                    display: "flex",
                    justifyContent: "space-between",
                    alignItems: "center",
                }}
            >
                <h1>User</h1>
            </div>
            {errors ? (
                <div className="alert">
                    {Object.keys(errors).map((key) => (
                        <p key={key}>{errors[key][0]}</p>
                    ))}
                </div>
            ) : (
                <div className="card-user">
                    <img src={user.image} style={{ width: "70px", height: "70px" }}/>
                    <h1>{user.name}</h1>
                    <p className="title">{user.position}</p>
                    <br />
                    <p className="title">{user.phone}</p>
                    <p className="title">{user.email}</p>
                </div>
            )}
        </div>
    );
};

export default User;
