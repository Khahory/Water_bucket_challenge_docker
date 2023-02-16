import axios from 'axios';
import BASE_URL from '../config';

const PostExerciseForm = async () => {
    const response = await axios.post(`${BASE_URL}/exercise`, {
        exercise: {
            bucket_x: '2',
            bucket_y: '10',
            amount_wanted_z: '4',
        },
    });
    return response.data;
};

export default PostExerciseForm;
