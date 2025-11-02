import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import EmployeesPage from '@/pages/EmployeesPage.vue';

const routes: RouteRecordRaw[] = [
  { path: '/', redirect: '/employees' },
  { path: '/employees', component: EmployeesPage }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
