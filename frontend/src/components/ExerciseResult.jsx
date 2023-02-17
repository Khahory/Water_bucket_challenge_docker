import React from "react";

const ExerciseResult = (props) => {
    const {result} = props;
    return (
        <div>
            <h3>Result</h3>
            <pre>
                {JSON.stringify(result, null, 2)}
            </pre>
        </div>
    );
}

export default ExerciseResult;