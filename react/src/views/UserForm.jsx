import React, { useEffect, useState } from "react";
import { Navigate, useNavigate, useParams } from "react-router-dom";
import axiosClient from "../axios-client";
import { userStateContext } from "../contexts/ContextProvider";

const UserForm = () => {
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);
    const navigate = useNavigate();
    const { setNotification } = userStateContext();
    const [positions, setPositions] = useState([]);
    const [user, setUser] = useState({
        name: null,
        email: null,
        phone: null,
        position_id: null,
        photo: null,
    });

    useEffect(() => {
        getPositions();
    }, []);

    const getPositions = () => {
        setLoading(true);
        axiosClient
            .get("/positions")
            .then(({ data }) => {
                setLoading(false);
                setPositions(data.positions);
            })
            .catch((err) => {
                setNotification(err.response.data.message);
                setLoading(false);
                const response = err.response;
                if (response && response.status === 422) {
                    if (response.data.errors) {
                        setErrors(response.data.errors);
                    }
                }
            });
    };

    const onSubmit = (ev) => {
        ev.preventDefault();
        // create user
        axiosClient
            .post(`/users`, user, {
                headers: {
                    "Content-Type": "multipart/form-data",
                    "Authorization": `Bearer ${localStorage.getItem("ACCESS_TOKEN")}`
                },
            })
            .then(({ data }) => {
                setNotification(data.message);
                navigate("/users");
            })
            .catch((err) => {
                const response = err.response;
                setNotification(response.data.message);
                if (response && response.status === 422) {
                    setErrors(response.data.fails);
                    setNotification(response.data.message);
                }
            });
    };

    return (
        <>
            <h1>New User</h1>
            <div className="card animated fadeInDown">
                {loading && <div className="text-center">Loading...</div>}
                {errors && (
                    <div className="alert">
                        {Object.keys(errors).map((key) => (
                            <p key={key}>{errors[key][0]}</p>
                        ))}
                    </div>
                )}
                {!loading && (
                    <form onSubmit={onSubmit} encType="multipart/form-data">
                        <input
                            value={user.name || ''}
                            onChange={(ev) =>
                                setUser({ ...user, name: ev.target.value })
                            }
                            placeholder="Name"
                        />
                        <input
                            type="email"
                            value={user.email || ''}
                            onChange={(ev) =>
                                setUser({ ...user, email: ev.target.value })
                            }
                            placeholder="Email"
                        />
                        <input
                            type="phone"
                            value={user.phone || ''}
                            onChange={(ev) =>
                                setUser({ ...user, phone: ev.target.value })
                            }
                            placeholder="Phone"
                        />
                        <select
                            name="position_id"
                            className="minimal"
                            onChange={(ev) =>
                                setUser({
                                    ...user,
                                    position_id: ev.target.value,
                                })
                            }
                            defaultValue={"select_position"}
                        >
                            <option
                                value="select_position"
                                disabled
                                key="select_position"
                            >
                                Select position
                            </option>
                            {positions.map((position) => (
                                <option value={position.id} key={position.id}>
                                    {position.name}
                                </option>
                            ))}
                        </select>
                        <input
                            type="file"
                            name="photo"
                            id="photo"
                            accept=".jpeg,.jpg"
                            // value={user.photo}
                            onChange={(ev) =>
                                setUser({
                                    ...user,
                                    photo: document
                                        .getElementById("photo")
                                        ?.files?.item(0),
                                })
                            }
                        />
                        <button className="btn">Save</button>
                    </form>
                )}
            </div>
        </>
    );
};

export default UserForm;
