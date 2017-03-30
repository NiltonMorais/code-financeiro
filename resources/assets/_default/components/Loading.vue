<template>
    <div class="spinner-fixed" v-if="loading">
        <div class="progress spinner">
            <div class="indeterminate"></div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                loading: false
            }
        },
        created(){
            window.Vue.http.interceptors.unshift((request,next) => {
                this.loading = true;
                next(()=>this.loading = false);
            });
        }
    }
</script>

<style>
.spinner{
  margin: 0;
}

.spinner-fixed{
  width: 100%;
  position: fixed;
  z-index: 998;
}
</style>
