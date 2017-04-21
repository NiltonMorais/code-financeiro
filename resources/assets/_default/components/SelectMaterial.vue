<template>
    <select></select>
</template>
<script>
    import 'select2';
    export default{
        props: {
            options: {
                type: Object,
                required: true
            },
            selected: {
                validator(value){
                    return typeof value == 'string' || typeof value == 'number' || value === null;
                }
            }
        },
        data(){
            return {
                val: null
            }
        },
        ready(){
            let self = this;
            $(this.$el)
                .select2(this.options)
                .on('change',function(){
                    self.selected = self.getSelectedValue(this.value);
                    self.val = self.selected;
                });
            $(this.$el).val(this.getValue(this.selected)).trigger('change');
        },
        watch: {
            'options.data'(data){
                $(this.$el).empty();
                $(this.$el).select2(this.options);
            },
            'selected'(selected){
                if(selected != $(this.$el).val()){
                    $(this.$el).val(this.getValue(selected)).trigger('change');
                }
            }
        },
        methods: {
            getSelectedValue(value){
                 return parseInt(value,10) !== 0 ? value : null;
            },
            getValue(value){
                 return value !== null ? value : 0
            }
        }
    }
</script>
