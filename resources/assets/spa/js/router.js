import AppCompoment from './components/App.vue';
import VueRouter from 'vue-router';
import routerMap from './router.map';
import store from './store/store';

const router = new VueRouter();

router.map(routerMap);

router.beforeEach(({to, next}) => {
    if(to.auth && !store.state.auth.check){
        return router.go({name: 'auth.login'});
    }
    next();
});

router.start({
    components: {
        'app': AppCompoment
    }
},'body');
