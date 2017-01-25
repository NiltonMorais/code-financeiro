import AppCompoment from './components/App.vue';
import VueRouter from 'vue-router';
import routerMap from './router.map';

const router = new VueRouter();

router.map(routerMap);

router.start({
    components: {
        'app': AppCompoment
    }
},'body');