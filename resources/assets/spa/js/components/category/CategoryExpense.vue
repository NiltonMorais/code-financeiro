<template>
    <div>
        <category-tree :categories="categories"></category-tree>

        <category-save :modal-options="modalOptionsSave" :category.sync="categorySave" :parent-options="parentOptions"
                       @save-category="saveCategory">
            <span slot="title">{{title}}</span>
            <div slot="footer">
                <button type="submit" class="btn btn-flat waves-effect green lighten-2 modal-close modal-action">Ok
                </button>
                <a class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</a>
            </div>
        </category-save>

        <modal :modal="modalOptionsDelete">
            <div slot="content" v-if="categoryDelete">
                <h4>Mensagem de confirmação</h4>
                <p><strong>Deseja excluir esta categoria?</strong></p>
                <div class="divider"></div>
                <p>Nome: <strong>{{categoryDelete.name}}</strong></p>
                <div class="divider"></div>
            </div>
            <div slot="footer">
                <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action" @click='destroy()'>
                    Ok
                </button>
                <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
            </div>
        </modal>
    </div>
</template>
<script>
    import categoryMixin from '../../mixins/category-mixin';
    export default{
        mixins: [categoryMixin],
        methods: {
            namespace(){
                return 'categoryExpense';
            }
        },
        computed: {
            title(){
                return 'Nova categoria de despesa'
             }
        }
    }
</script>
