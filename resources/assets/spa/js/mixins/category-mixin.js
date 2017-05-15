import CategoryTreeComponent from '../components/category/CategoryTree.vue';
import CategorySaveComponent from '../components/category/CategorySave.vue';
import ModalComponent from '../../../_default/components/Modal.vue';
import store from '../store/store';

export default{
    components: {
        'category-tree': CategoryTreeComponent,
        'category-save': CategorySaveComponent,
        'modal': ModalComponent
    },
    data(){
        return {
            categorySave: {
                id: 0,
                name: '',
                parent_id: 0
            },
            title: ''
        }
    },
    computed: {
        categories(){
            return store.state[this.namespace()].categories;
        },
        categoriesFormatted(){
            return store.getters[`${this.namespace()}/categoriesFormatted`];
        },
        categoryDelete(){
            return store.state[this.namespace()].category;
        },
        parentOptions(){
            return {
                data: this.categoriesFormatted,
                templateResult(category){
                    let margin = '&nbsp'.repeat(category.level * 6)
                    let text = category.hasChildren ? `<strong>${category.text}</strong>` : category.text;
                    return `${margin}${text}`;
                },
                escapeMarkup(m){
                    return m;
                }
            }
        },
        modalOptionsSave(){
            return {id: `modal-category-save-${this._uid}`};
        },
        modalOptionsDelete(){
            return {id: `modal-category-delete-${this._uid}`};
        }
    },
    created(){
        return store.dispatch(`${this.namespace()}/query`);
    },
    methods: {
        saveCategory(){
            store.dispatch(`${this.namespace()}/save`, this.categorySave).then((response)=> {
                $(`#${this.modalOptionsSave.id}`).modal('close');
                if (this.categorySave.id === 0) {
                    Materialize.toast('Categoria adicionada com sucesso!', 5000);
                } else {
                    Materialize.toast('Categoria alterada com sucesso!', 5000);
                }
                this.resetScope();
            });
        },
        destroy(){
            store.dispatch(`${this.namespace()}/delete`).then(response => {
                Materialize.toast('Categoria excluída com sucesso!', 5000);
            });
        },
        modalNew(category){
            this.title = 'Nova categoria';
            this.categorySave = {
                id: 0,
                name: '',
                parent_id: category === null ? null : category.id
            };
            store.commit(`${this.namespace()}/setParent`,category);
            $(`#${this.modalOptionsSave.id}`).modal('open');
        },
        modalEdit(category, parent){
            this.title = 'Editar categoria';
            this.categorySave = {
                id: category.id,
                name: category.name,
                parent_id: category.parent_id
            };
            store.commit(`${this.namespace()}/setCategory`,category);
            store.commit(`${this.namespace()}/setParent`,parent);
            $(`#${this.modalOptionsSave.id}`).modal('open');
        },
        modalDelete(category, parent){
            store.commit(`${this.namespace()}/setCategory`,category);
            store.commit(`${this.namespace()}/setParent`,parent);
            $(`#${this.modalOptionsDelete.id}`).modal('open');
        },
        resetScope(){
            this.categorySave = {
                id: 0,
                name: '',
                parent_id: 0
            };
        }
    },
    events: {
        'category-new'(category){
            this.modalNew(category);
        },
        'category-edit'(category, parent){
            this.modalEdit(category, parent);
        },
        'category-delete'(category, parent){
            this.modalDelete(category, parent);
        }
    }

}