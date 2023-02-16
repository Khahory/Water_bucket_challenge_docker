import axios from 'axios';
import BASE_URL from '../config';

const fetchStatus = async () => {
  const response = await axios.get(`${BASE_URL}/welcome`);
  return response.data;
};

export default fetchStatus;
