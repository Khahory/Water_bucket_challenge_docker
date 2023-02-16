import React from 'react';
import { useState, useEffect } from 'react';
import fetchStatus from "./services/server";

function App() {
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
            <h1>React App</h1>
            <div>
                <h2>Server Status</h2>
                <p>{server_status.message}</p>
            </div>
        </div>
    );
}

export default App;
