<template>
    <div>
        <form name="form" method="POST" @submit.prevent="submit" id="form-category">
            <modal :modal="modalOptions">
                <div slot="content">
                    <h4>
                        <slot name="title"></slot>
                        <h4>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" v-model="category.name" placeholder="Digite o nome"
                                           name="name" class="validate"
                                           v-validate data-vv-rules="required" :class="{'invalid': errors.has('name')}"
                                           data-vv-as="nome"/>
                                    <label class="active" :data-error="errors.first('name')">Nome</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select-material :options="parentOptions" :selected.sync="category.parent_id"
                                                     name="parent_id"></select-material>
                                    <label class="active">Categoria pai</label>
                                </div>
                            </div>
                </div>
                <div slot="footer">
                    <slot name="footer"></slot>
                </div>
            </modal>
        </form>
    </div>
</template>
<script>
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import validatorOffRemoveMixim from '../../mixins/validator-off-remove-mixin';
    import SelectMaterialComponent from '../../../../_default/components/SelectMaterial.vue';
    export default{
        mixins: [validatorOffRemoveMixim],
        components: {
            'modal': ModalComponent,
            'select-material': SelectMaterialComponent
        },
        props: {
            category: {
                type: Object,
                required: true
            },
            modalOptions: {
                type: Object,
                required: true
            },
            parentOptions: {
                type: Object,
                required: true
            }
        },
        data(){
            return {
                    options: {
                        data: [
                            {id: 1, text: "texto 1"},
                            {id: 2, text: "texto 2"},
                        ]
                    },
                    selected: 2
                }
        },
        methods: {
            submit(){
                this.$validator.validateAll().then(success => {
                    if(success){
                        this.$emit('save-category');
                    }else{
                        Materialize.toast("O campo de nome é obrigatório!", 3000);
                    }
                });
            }
        }
    }

</script>