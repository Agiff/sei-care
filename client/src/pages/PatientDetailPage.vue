<script>
  import { mapActions, mapState } from 'pinia';
  import { usePatientStore } from '../stores/patient';

  export default {
    name: 'PatientDetailPage',
    computed: {
      ...mapState(usePatientStore, ['patientDetail'])
    },
    methods: {
      ...mapActions(usePatientStore, ['fetchPatientDetail'])
    },
    created() {
      this.fetchPatientDetail(this.$route.params.id);
    }
  }
</script>

<template>
  <div class="container pt-3">
    <h1>Patient Detail</h1>
    <hr>
    <div>
      <h6>ID: {{ patientDetail.id }}</h6>
      <h6>Name: {{ patientDetail.name }}</h6>
      <h6>Gender: {{ patientDetail.sex }}</h6>
      <h6>Religion: {{ patientDetail.religion }}</h6>
      <h6>Phone: {{ patientDetail.phone }}</h6>
      <h6>Address: {{ patientDetail.address }}</h6>
      <h6>NIK: {{ patientDetail.nik }}</h6>
    </div>
  </div>
</template>