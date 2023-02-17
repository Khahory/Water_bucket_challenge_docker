import React, {useState, useEffect} from 'react';
import PostExerciseForm from "../services/PostExerciseForm";

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
        setExercise((prevExercise) => {
            return {
                ...prevExercise,
                [name]: value,
            }
        });
    }

    return (
        <form onSubmit={handleSubmit}>
            <label>
                Bucket x:
                <input type="text" name="bucketX" onChange={handleChange} />
            </label>
            <br/>
            <label>
                Bucket Y:
                <input type="text" name="bucketY" onChange={handleChange} />
            </label>
            <br/>
            <label>
                Amount wanted Z:
                <input type="text" name="amountZ" onChange={handleChange} />
            </label>
            <br/><br/>
            <input type="submit" value="Submit"/>
        </form>
    );
}

export default ExerciseForm;