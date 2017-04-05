<template>
    <form name="form" method="GET" @submit="submit()">
        <div class="filter-group">
            <button class="btn waves-effect" @click.prevent="submit">
                <i class="material-icons">search</i>
            </button>
            <div class="filter-wrapper">
                <input type="text" v-model="model" placeholder="Buscar.."/>
            </div>
        </div>
    </form>
</template>
<script>
    export default{
        props: {
            model: {
                required: true,
                type: String
            }
        },
        methods: {
            submit(){
                this.$emit('on-submit');
            }
        }
    }
</script>
