import axios from 'axios';
import BASE_URL from '../config';

const PostExerciseForm = async ({bucket_x, bucket_y, amount_wanted_z}) => {
    const response = await axios.post(`${BASE_URL}/exercise`, {
        exercise: {
            bucket_x,
            bucket_y,
            amount_wanted_z,
        },
    });
    return response.data;
};

export default PostExerciseForm;
