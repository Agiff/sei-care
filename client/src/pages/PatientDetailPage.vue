<script>
  import { mapActions, mapState } from 'pinia';
  import { usePatientStore } from '../stores/patient';

  export default {
    name: 'PatientDetailPage',
    computed: {
      ...mapState(usePatientStore, ['patientDetail'])
    },
    methods: {
      ...mapActions(usePatientStore, ['fetchPatientDetail', 'deletePatient']),
      onDelete(id) {
        this.deletePatient(id).then(() => this.$router.back());
      }
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
      <div class="card p-3" style="width: 30rem;">
        <div class="row">
          <div class="col-3">
            <h6>ID</h6>
            <h6>Name</h6>
            <h6>Gender</h6>
            <h6>Religion</h6>
            <h6>Phone</h6>
            <h6>Address</h6>
            <h6>NIK</h6>
          </div>
          <div class="col-1">
            <h6>:</h6>
            <h6>:</h6>
            <h6>:</h6>
            <h6>:</h6>
            <h6>:</h6>
            <h6>:</h6>
            <h6>:</h6>
          </div>
          <div class="col-6">
            <h6>{{ patientDetail.id }}</h6>
            <h6>{{ patientDetail.name }}</h6>
            <h6>{{ patientDetail.sex }}</h6>
            <h6>{{ patientDetail.religion }}</h6>
            <h6>{{ patientDetail.phone }}</h6>
            <h6>{{ patientDetail.address }}</h6>
            <h6>{{ patientDetail.nik }}</h6>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-between" style="width: 30rem;">
        <div>
          <button type="button" class="btn btn-success my-2 mx-2" @click="$router.push(`/edit/${patientDetail.id}`)">Edit</button>
          <button type="button" class="btn btn-danger my-2" @click="onDelete(patientDetail.id)">Delete</button>
        </div>
        <div>
          <button type="button" class="btn btn-secondary my-2" @click="$router.back()">Back</button>
        </div>
      </div>
    </div>
  </div>
</template>