import { defineStore } from 'pinia';
import axios from 'axios';

export const usePatientStore = defineStore('patient', {
  state: () => ({
    baseUrl: 'http://localhost:8000',
    patients: []
  }),
  getters: {
    doubleCount: (state) => state.count * 2,
  },
  actions: {
    async fetchPatients() {
      try {
        const { data } = await axios.get(this.baseUrl + '/patients/api');
        this.patients = data.result;
      } catch (error) {
        console.log(error);
      }
    }
  },
})
