import axios from 'axios';

const BASE_URL = 'http://127.0.0.1:8000/api/';

export const api = axios.create({
	baseURL: BASE_URL,
	headers: {
		'Content-Type': 'application/json'
	}
});

api.interceptors.request.use((config) => {
	const store = JSON.parse(localStorage.getItem('user'));
	const token = store.token;
	if (token) {
		config.headers.Authorization = `Bearer ${token}`;
	}
	return config
});

export default api;
