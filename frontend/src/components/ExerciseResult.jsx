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

    return (
        <div>
            <h3>Result</h3>
            <table>
                <thead>
                <tr>
                    <th>Bucket x</th>
                    <th>Bucket y</th>
                    <th>Explanation</th>
                </tr>
                </thead>
                <tbody>
                {best_solution.steps.map((step, index) => (
                    <tr key={index}>
                        <td>{step.current_bucket_main}</td>
                        <td>{step.current_bucket_other}</td>
                        <td>
                            {step.action}
                            <div>
                                {(step.amount_wanted_z === step.current_bucket_main || step.amount_wanted_z === step.current_bucket_other) &&
                                    <b>Solved</b>
                                }
                            </div>
                        </td>
                    </tr>
                ))}
                </tbody>
            </table>
            <pre>
                {JSON.stringify(best_solution, null, 2)}
            </pre>
        </div>
    );
}

export default ExerciseResult;