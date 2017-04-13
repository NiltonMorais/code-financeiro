<template>
    <div id="app">
        <loading></loading>
        <header v-if="showMenu">
            <menu></menu>
        </header>

        <main>
            <router-view></router-view>
        </main>

        <footer class="page-footer">
            <div class="footer-copyright">
                <div class="container">
                    © {{year}} <a class="grey-text text-lighten-4" href="http://code.education">Code Education</a>
                </div>
            </div>
        </footer>


    </div>
</template>
<script>
    import MenuComponent from './Menu.vue';
    import LoadingComponent from '../../../_default/components/Loading.vue';
    import store from '../store/store';
    export default{
        components: {
            'menu': MenuComponent,
            'loading': LoadingComponent,
        },
        data(){
            return{
                year: new Date().getFullYear()
            }
        },
        computed: {
            isAuth(){
                return store.state.auth.check;
            },
            showMenu(){
                return this.isAuth && this.$route.name != 'auth.login';
            }
        }
    }
</script>
<style type="text/css">
    #app{
      display: flex;
      min-height: 100vh;
      flex-direction: column
    }

    main{
      flex: 1 0 auto
    }


</style>
