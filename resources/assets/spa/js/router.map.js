import LoginComponent from './components/Login.vue';
import DashboardComponent from './components/Dashboard.vue';

export default{
    '/login': {
        name: 'auth.login',
        component: LoginComponent
    },
    '/dashboard': {
        name: 'dashboard',
        component: DashboardComponent
    }
}