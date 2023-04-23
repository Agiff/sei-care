import { defineStore } from 'pinia';
import axios from 'axios';

export const usePatientStore = defineStore('patient', {
  state: () => ({
    baseUrl: 'http://localhost:8000',
    patients: [],
    patientDetail : {}
  }),
  getters: {
    doubleCount: (state) => state.count * 2,
  },
  actions: {
    async fetchPatients() {
      try {
        const { data } = await axios.get(`${this.baseUrl}/patients/api`);
        this.patients = data.result;
      } catch (error) {
        console.log(error);
      }
    },
    async fetchPatientDetail(id) {
      try {
        const { data } = await axios.get(`${this.baseUrl}/patients/api/${id}`);
        this.patientDetail = data.result;
      } catch (error) {
        console.log(error);
      }
    },
    async createPatient(input) {
      try {
        const { data } = await axios.post(`${this.baseUrl}/patients/api/create`, input);
        await this.fetchPatients();
        console.log(data);
        this.router.push('/');
      } catch (error) {
        console.log(error);
      }
    },
    async deletePatient(id) {
      try {
        const { data } = await axios.delete(`${this.baseUrl}/patients/api/delete/${id}`);
        await this.fetchPatients();
        console.log(data);
      } catch (error) {
        console.log(error);
      }
    },
  },
})
