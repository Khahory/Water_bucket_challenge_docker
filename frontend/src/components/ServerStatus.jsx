import React, {useState, useEffect} from 'react';
import fetchStatus from "../services/Server";

const ServerStatus = () => {
    const [server_status, setServer_status] = useState(
        {message: "Loading...", status: false}
    );

    useEffect(() => {
        const getServerStatus = async () => {
            console.log("Fetching server status...")
            const status = await fetchStatus();
            setServer_status(status);
        }
        getServerStatus()
            .then(r => r)
            .catch(e => {
                // print error message
                console.log(e.message)
                setServer_status({message: "Error conneting to server, retry later", status: false});
            });
    }, []);


    return (
        <div>
            <h2>Server Status</h2>
            <p>{server_status.message}</p>
        </div>
    );

}

export default ServerStatus;
