import React, {useState, useEffect} from 'react';
import PostExerciseForm from "../services/PostExerciseForm";
import {formatingInput} from "../helpers/Form";

const ExerciseForm = () => {
    // my state variables
    const [exercise, setExercise] = useState({
        bucketX: "",
        bucketY: "",
        amountZ: "",
    });

    // post request to backend
    const handleSubmit = (event) => {
        PostExerciseForm({
            bucket_x: exercise.bucketX,
            bucket_y: exercise.bucketY,
            amount_wanted_z: exercise.amountZ,
        }).then((response) => {
            console.log(response);
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
    );
}

export default ExerciseForm;