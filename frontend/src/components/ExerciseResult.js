import React from "react";

const ExerciseResult = (props) => {
    const {result} = props;
    return (
        <div>
            <h3>Result</h3>
            <p>{JSON.stringify(result)}</p>
        </div>
    );
}

export default ExerciseResult;