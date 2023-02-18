import React from "react";

const ExerciseResult = (props) => {
    const {result} = props;

    // some validation
    if (!result.status || !result.is_valid)
        return (<h3>Something goes wrong, reload the page</h3>)

    // get the solution from the result
    let {res_x, res_y} = result.data;
    res_x = res_x.is_done ? res_x : null;
    res_y = res_y.is_done ? res_y : null;

    // compare the solutions
    const best_solution = res_x && res_y ?
        (res_x.step_times < res_y.step_times ? res_x : res_y) :
        (res_x ? res_x : res_y);

    console.warn(best_solution)


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