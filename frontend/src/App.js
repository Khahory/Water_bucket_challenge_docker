import React, {useState} from 'react';
import ServerStatus from "./components/ServerStatus";
import ExerciseForm from "./components/ExerciseForm";

function App() {
    // my state variables
    const [server_status, setServer_status] = useState(
        {message: "Loading...", status: false}
    );

    const updateServerStatus = (status) => {
        setServer_status(status);
    }

    return (
        <div>
            <h1>React App</h1>
            <ServerStatus updateServerStatus={updateServerStatus} />
            {server_status.status &&
                <ExerciseForm />
            }
        </div>
    );
}

export default App;
