import api from '@/services/api';
import { defineStore } from 'pinia';

export const useUrlStore = defineStore('url', {
  state: () => ({
    urls: null,
    loading: false,
    errors: null,
    message: null
  }),
  actions: {
    clearMessage() {
      this.message = null;
      this.errors = null;
    },

    async getUrls() {
      this.loading = true;
      this.message = null;
      try {
        const response = await api.get('links');
        this.loading = false;
        console.log(response.data);
        this.urls = response.data;
        return true;
      } catch (errors) {
        this.loading = false;
        this.errors = errors?.response?.data?.errors || errors;
        console.log(this.errors);
        return false;
      }
    },

    async createShortLink(data) {
          this.loading = true;
          this.message = null;
          try {
            const response = await api.post('shorten', data);
            this.loading = false;
            console.log(response.data);
            this.message = 'Shortlink created succesfully';
            return true
          } catch (errors) {
            this.loading = false;
            this.errors = errors.response.data.errors;
            console.log(this.errors);
            return false
          }
        },
  },
  persist: true
});
