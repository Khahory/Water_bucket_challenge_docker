// This function is used to format the input of the user
const formatingInput = (value) => {
    const regex = /^[1-9\b]+$/; // only allow numbers
    if (value === '' || regex.test(value)) {
        return value;
    }

}

export {formatingInput};