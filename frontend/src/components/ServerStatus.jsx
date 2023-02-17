import React, {useState, useEffect} from 'react';
import fetchStatus from "../services/Server";

const ServerStatus = ({updateServerStatus}) => {
    const [server_status, setServer_status] = useState(
        {message: "Loading...", status: false}
    );

    useEffect(() => {
        const getServerStatus = async () => {
            console.log("Fetching server status...")
            const status = await fetchStatus();
            setServer_status(status);
            updateServerStatus(status);
        }
        getServerStatus()
            .then(r => r)
            .catch(e => {
                const status = {message: "Error conneting to server (Backend), retry later", status: false};

                // print error message
                console.log(e.message)
                setServer_status(status);
                updateServerStatus(status);
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
