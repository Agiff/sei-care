<script>
import { mapActions, mapState } from 'pinia';
import { usePatientStore } from '../stores/patient';

  export default {
    name: 'PatientFormPage',
    data() {
      return {
        patientInput: {
          name: '',
          sex: '',
          religion: '',
          phone: '',
          address: '',
          nik: ''
        }
      }
    },
    computed: {
      ...mapState(usePatientStore, ['patientDetail'])
    },
    methods: {
      ...mapActions(usePatientStore, ['createPatient', 'fetchPatientDetail', 'updatePatient']),
      submitInput() {
        if (this.$route.params.id) {
          this.updatePatient(this.patientInput, this.$route.params.id);
        } else {
          this.createPatient(this.patientInput);
        }
      }
    },
    created() {
      if (this.$route.params.id) {
        this.fetchPatientDetail(this.$route.params.id)
          .then(() => this.patientInput = this.patientDetail);
      }
    }
  }
</script>

<template>
  <div class="container pt-3 d-flex justify-content-center align-items-center vh-100">
    <form class="card p-3 py-4 w-50" @submit.prevent="submitInput">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" v-model="patientInput.name">
      </div>
      <div class="mb-3">
        <label for="sex" class="form-label">Gender</label>
        <select id="sex" class="form-select" v-model="patientInput.sex">
          <option value="" selected disabled>Choose..</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="religion" class="form-label">Religion</label>
        <select id="religion" class="form-select" v-model="patientInput.religion">
          <option value="" selected disabled>Choose..</option>
          <option value="Islam">Islam</option>
          <option value="Christian">Christian</option>
          <option value="Hinduism">Hinduism</option>
          <option value="Buddhism">Buddhism</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" v-model="patientInput.phone">
      </div>
      <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" v-model="patientInput.address">
      </div>
      <div class="mb-3">
        <label for="nik" class="form-label">NIK</label>
        <input type="text" class="form-control" id="nik" v-model="patientInput.nik">
      </div>
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary"> {{ this.$route.params.id ? 'Edit' : 'Add' }} </button>
        <button type="button" class="btn btn-secondary" @click="$router.back()">Back</button>
      </div>
    </form>
  </div>
</template>