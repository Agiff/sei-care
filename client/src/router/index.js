import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../pages/HomePage.vue';
import PatientDetailPage from '../pages/PatientDetailPage.vue';
import PatientFormPage from '../pages/PatientFormPage.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomePage
    },
    {
      path: '/:id',
      name: 'patienDetail',
      component: PatientDetailPage
    },
    {
      path: '/form',
      name: 'patientForm',
      component: PatientFormPage
    },
  ]
})

export default router
