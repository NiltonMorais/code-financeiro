import LoginComponent from './components/Login.vue';
import LogoutComponent from './components/Logout.vue';
import DashboardComponent from './components/Dashboard.vue';
import BankAccountListComponent from './components/bank-account/BankAccountList.vue';
import BankAccountCreateComponent from './components/bank-account/BankAccountCreate.vue';
import BankAccountUpdateComponent from './components/bank-account/BankAccountUpdate.vue';
import CategoryListComponent from './components/category/CategoryList.vue';

export default{
    '/login': {
        name: 'auth.login',
        component: LoginComponent,
        auth: false
    },
    '/logout': {
        name: 'auth.logout',
        component: LogoutComponent,
        auth: true
    },
    '/dashboard': {
        name: 'dashboard',
        component: DashboardComponent,
        auth: true
    },
    '/bank-accounts': {
        component: {template: "<router-view></router-view>"},
        auth: true,
        subRoutes: {
            '/': {
                name: 'bank-account.list',
                component: BankAccountListComponent
            },
            '/create': {
                name: 'bank-account.create',
                component: BankAccountCreateComponent
            },
            '/:id/update': {
                name: 'bank-account.update',
                component: BankAccountUpdateComponent
            }
        }
    },
    '/categories': {
        name: 'category.list',
        component: CategoryListComponent,
        auth: true
    }
}