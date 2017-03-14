import LoginComponent from './components/Login.vue';
import LogoutComponent from './components/Logout.vue';
import DashboardComponent from './components/Dashboard.vue';

export default{
    '/login': {
        name: 'auth.login',
        component: LoginComponent
    },
    '/logout': {
        name: 'auth.logout',
        component: LogoutComponent
    },
    '/dashboard': {
        name: 'dashboard',
        component: DashboardComponent
    }
}