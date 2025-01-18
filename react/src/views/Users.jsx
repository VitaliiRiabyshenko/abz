import React, { useEffect, useState } from "react";
import axiosClient from "../axios-client";
import { Link, useNavigate } from "react-router-dom";
import { userStateContext } from "../contexts/ContextProvider";

const Users = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(false);
    const { setNotification } = userStateContext();
    const [errors, setErrors] = useState(null);
    const navigate = useNavigate();
    const [page, setPage] = useState(1);
    const [count, setCount] = useState(6);
    const [nextUrl, setNextUrl] = useState(0);

    useEffect(() => {
        getUsers();
    }, [page]);

    const getUsers = () => {
        setLoading(true);
        axiosClient
            .get(`/users?page=${page}&count=${count}`)
            .then(({ data }) => {
                setLoading(false);
                setUsers((pre) => [...pre, ...data.users]);
                setNextUrl(data.links.next_url);
            })
            .catch((err) => {
                setNotification(err.response.data.message ?? 'Something went wrong');
                setLoading(false);
                const response = err.response;
                if (response && response.status === 422) {
                    if (response.data.errors) {
                        setErrors(response.data.errors);
                    }
                }
                if (response && response.status === 404) {
                    navigate("/404");
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
                <h1>Users</h1>
                <Link to="/users/create" className="btn-add">
                    Add new
                </Link>
            </div>
            {errors && (
                <div className="alert">
                    {Object.keys(errors).map((key) => (
                        <p key={key}>{errors[key][0]}</p>
                    ))}
                </div>
            )}
            <div className="card animated fadeInDown">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Registration timestamp</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    {loading ? (
                        <tbody>
                            <tr>
                                <th colSpan="5" className="text-center">
                                    Loading...
                                </th>
                            </tr>
                        </tbody>
                    ) : (
                        <tbody>
                            {users.map((user) => (
                                <tr key={user.id}>
                                    <td>{user.id}</td>
                                    <td>
                                        <Link to={`/users/${user.id}`}>
                                            {user.name}
                                        </Link>
                                    </td>
                                    <td>{user.email}</td>
                                    <td>{user.phone}</td>
                                    <td>{user.position}</td>
                                    <td>{user.registration_timestamp}</td>
                                    <td>
                                        <img src={user.image} style={{ width: "70px", height: "70px" }}/>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    )}
                </table>
                {nextUrl && (
                    <button
                        className="btn btn-success"
                        onClick={() => {
                            setPage(page + 1);
                        }}
                    >
                        Show more
                    </button>
                )}
            </div>
        </div>
    );
};

export default Users;
