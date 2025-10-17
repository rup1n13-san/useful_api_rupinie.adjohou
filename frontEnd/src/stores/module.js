import api from '@/services/api';
import { defineStore } from 'pinia';

export const useModuleStore = defineStore('module', {
	state: () => ({
		modules: null,
		loading: false,
		errors: null,
		message: null
	}),
	actions: {
		clearMessage() {
			this.message = null;
			this.errors = null;
		},

		async getModules() {
			this.loading = true;
			this.message = null;
			try {
				const response = await api.get('user/modules');
				this.loading = false;
				console.log(response.data);
				this.message = 'Modules fetched successfully';
				this.modules = response.data;
				return true;
			} catch (errors) {
				this.loading = false;
				this.errors = errors?.response?.data?.errors || errors;
				console.log(this.errors);
				return false;
			}
		},

		async activate(moduleId) {
			this.loading = true;
			this.message = null;
			try {
				const response = await api.post(`/modules/${moduleId}/activate`);
				this.loading = false;
        console.log(response.data)
				this.message = response.data.message;
				this.getModules();
			} catch (errors) {
				this.loading = false;
				this.errors = errors?.response?.data?.errors || errors;
				console.log(this.errors);
				return false;
			}
		},

		async deactivate(moduleId) {
			this.loading = true;
			this.message = null;
			try {
				const response = await api.post(`/modules/${moduleId}/deactivate`);
				this.loading = false;
				this.message = response.data.message;
				this.getModules();
			} catch (errors) {
				this.loading = false;
				this.errors = errors?.response?.data?.errors || errors;
				console.log(this.errors);
				return false;
			}
		}
	},
	persist: true
});
