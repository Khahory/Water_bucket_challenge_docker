import React from 'react';

const ExerciseForm = () => {

    // post request to backend
    const handleSubmit = (event) => {
        alert('handleSubmit');
        event.preventDefault(); // Prevents the default action of submitting the form
    }

    return (
        <form onSubmit={handleSubmit}>
            <label>
                Bucket x:
                <input type="text"/>
            </label>
            <br/>
            <label>
                Bucket Y:
                <input type="text"/>
            </label>
            <br/>
            <label>
                Amount wanted Z:
                <input type="text"/>
            </label>
            <br/><br/>
            <input type="submit" value="Submit"/>
        </form>
    );
}

export default ExerciseForm;