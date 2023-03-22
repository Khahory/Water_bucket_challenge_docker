import BASE_URL from '../config';

// const PostExerciseForm = async ({bucket_x, bucket_y, amount_wanted_z}) => {
//     const response = await axios.post(`${BASE_URL}/exercise`, {
//         exercise: {
//             bucket_x,
//             bucket_y,
//             amount_wanted_z,
//         },
//     });
//     return response.data;
// };

// ahora con fetch
const PostExerciseForm = async ({bucket_x, bucket_y, amount_wanted_z}) => {
    const requestOptions = {
        method: 'POST',
        body: JSON.stringify({
            bucket_x,
            bucket_y,
            amount_wanted_z,
        })
    };

    const response = await fetch(`${BASE_URL}/exercise`, requestOptions);
    return await response.json();
}

export default PostExerciseForm;
