import { defineStore } from 'pinia';
import axios from 'axios';
import { failureAlert, successAlert } from '../helpers';

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
        failureAlert(error.response.data.status.code, error.response.data.status.message);
      }
    },
    async fetchPatientDetail(id) {
      try {
        const { data } = await axios.get(`${this.baseUrl}/patients/api/${id}`);
        this.patientDetail = data.result;
      } catch (error) {
        failureAlert(error.response.data.status.code, error.response.data.status.message);
      }
    },
    async createPatient(input) {
      try {
        const { data } = await axios.post(`${this.baseUrl}/patients/api/create`, input);
        await this.fetchPatients();
        console.log(data);
        this.router.back();
        successAlert('Patient added');
      } catch (error) {
        failureAlert(error.response.data.status.code, error.response.data.status.message);
      }
    },
    async deletePatient(id) {
      try {
        const { data } = await axios.delete(`${this.baseUrl}/patients/api/delete/${id}`);
        await this.fetchPatients();
        console.log(data);
        successAlert('Patient removed');
      } catch (error) {
        failureAlert(error.response.data.status.code, error.response.data.status.message);
      }
    },
    async updatePatient(input, id) {
      try {
        const { data } = await axios.put(`${this.baseUrl}/patients/api/update/${id}`, input);
        await this.fetchPatients();
        console.log(data);
        this.router.back();
        successAlert('Patient updated');
      } catch (error) {
        failureAlert(error.response.data.status.code, error.response.data.status.message);
      }
    },
  },
})
