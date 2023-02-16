import React from 'react';
import {useState, useEffect} from 'react';
import fetchStatus from "../services/Server";

const ServerStatus = () => {
    const [server_status, setServer_status] = useState(
        {message: "Loading...", status: false}
    );

    useEffect(() => {
        const getServerStatus = async () => {
            const status = await fetchStatus();
            setServer_status(status);
        }
        getServerStatus().then(r => r)
    }, []);


    return (
        <div>
            <h2>Server Status</h2>
            <p>{server_status.message}</p>
        </div>
    );

}

export default ServerStatus;
