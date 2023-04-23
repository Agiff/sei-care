<script>
  import { mapActions, mapState } from 'pinia';
  import { usePatientStore } from '../stores/patient';

  export default {
    name: 'HomePage',
    computed: {
      ...mapState(usePatientStore, ['patients'])
    },
    methods: {
      ...mapActions(usePatientStore, ['fetchPatients', 'deletePatient'])
    },
    created() {
      this.fetchPatients();
    }
  }
</script>

<template>
  <div class="container pt-3">
    <h1>Home</h1>
    <hr>
    <div>
      <button type="button" class="btn btn-primary my-2 mt-4 mb-3" @click="$router.push('/form')">Add Patient</button>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Religion</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">NIK</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(patient, index) in patients" :key="patient.id">
            <th scope="row" class="align-middle">{{ index+1 }}</th>
            <td class="align-middle">{{ patient.name }}</td>
            <td class="align-middle">{{ patient.sex }}</td>
            <td class="align-middle">{{ patient.religion }}</td>
            <td class="align-middle">{{ patient.phone }}</td>
            <td class="align-middle">{{ patient.address }}</td>
            <td class="align-middle">{{ patient.nik }}</td>
            <td class="align-middle">
              <button type="button" class="btn btn-primary my-2" @click="$router.push(`/${patient.id}`)">See Details</button>
              <button type="button" class="btn btn-success my-2 mx-2">Edit</button>
              <button type="button" class="btn btn-danger my-2" @click="deletePatient(patient.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>