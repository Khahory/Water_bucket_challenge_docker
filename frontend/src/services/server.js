import axios from 'axios';

const BASE_URL = 'http://localhost:4444/backend/api/v1';

const fetchStatus = async () => {
  const response = await axios.get(`${BASE_URL}/welcome`);
  return response.data;
};

export default fetchStatus;
