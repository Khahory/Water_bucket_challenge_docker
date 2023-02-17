import React, {useState} from 'react';
import PostExerciseForm from "../services/PostExerciseForm";
import {formatingInput} from "../helpers/Form";
import ExerciseResult from "./ExerciseResult";

const ExerciseForm = () => {
    // my state variables
    const [exercise, setExercise] = useState({
        bucketX: "",
        bucketY: "",
        amountZ: "",
    });
    const [result, setResult] = useState([]);

    // post request to backend
    const handleSubmit = (event) => {
        PostExerciseForm({
            bucket_x: exercise.bucketX,
            bucket_y: exercise.bucketY,
            amount_wanted_z: exercise.amountZ,
        }).then((response) => {
            // set result
            console.log(response);
            setResult(response);
        });
        event.preventDefault(); // Prevents the default action of submitting the form
    }

    // handle change in input
    const handleChange = (event) => {
        const {name, value} = event.target;
        // only allow numbers
        if (formatingInput(value) !== undefined) {
            setExercise((prevExercise) => {
                return {
                    ...prevExercise,
                    [name]: value,
                }
            });
        }
    }

    // handle key press
    const handleKeyPress = (event) => {
        // only allow numbers
        if (event.keyCode < 48 || event.keyCode > 57) {
            event.preventDefault();
        }
    }

    // handle input props
    const propsInput = {
        type: "number",
        pattern: "[0-9]*",
        inputMode: "numeric",
        min: 1,
        onKeyUp: handleKeyPress,
        onChange: handleChange,
    }
    return (
        <div>
            <form onSubmit={handleSubmit}>
                <label>
                    Bucket x:
                    <input name="bucketX" {...propsInput} />
                </label>
                <br/>
                <label>
                    Bucket Y:
                    <input name="bucketY" {...propsInput} />
                </label>
                <br/>
                <label>
                    Amount wanted Z:
                    <input name="amountZ" {...propsInput} />
                </label>
                <br/><br/>
                <input type="submit" value="Submit" disabled={
                    exercise.bucketX === "" ||
                    exercise.bucketY === "" ||
                    exercise.amountZ === ""
                }/>
            </form>
            <ExerciseResult result={result}/>
        </div>
    );
}

export default ExerciseForm;