import api from '@/services/api';
import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
	state: () => ({
		connectedUser: null,
		users: [],
		loading: false,
		errors: null,
		token: null,
		message: null
	}),
	actions: {
		clearMessage() {
			this.message = null;
			this.errors = null;
		},

		async register(user) {
			this.loading = true;
			this.message = null;
			try {
				const response = await api.post('register', user);
				this.loading = false;
				console.log(response.data);
				this.message = 'registration successful';
        return true
			} catch (errors) {
				this.loading = false;
				this.errors = errors.response.data.errors;
				console.log(this.errors);
        return false
			}
		},

		async login(user) {
			this.loading = true;
			this.message = null;
			try {
				const response = await api.post('login', user);
				this.loading = false;
				console.log(response.data);
        this.token = response.data.token
        this.connectedUser = response.data.user
				this.message = 'login successful';
        return true
			} catch (errors) {
				this.loading = false;
				this.errors = errors.response.data.errors;
				console.log(this.errors);
        return false
			}
		}
	},
  persist: true
});
