import axios from 'axios';
import axiosRetry from 'axios-retry';
import BASE_URL from '../config';

const fetchStatus = async () => {
    // Because Axios Retry integrates with Axios as an interceptor, the request flow is
    // automatically diverted to Axios Retry before being processed by Axios.
    axiosRetry(axios, {
        retries: 5, // número máximo de intentos
        retryDelay: (retryCount) => {
            return 1000 * Math.pow(2, retryCount); // espera creciente entre intentos (en milisegundos)
        },
    });

    const response = await axios.get(`${BASE_URL}/welcome`);
    return response.data;
};

export default fetchStatus;
