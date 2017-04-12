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
        ready(){
            let self = this;
            $(this.$el)
                .select2(this.options)
                .on('change',function(){
                    if(parseInt(this.value,10) !== 0){
                        self.selected = this.value
                    }else{
                        self.selected = null;
                    }
                });
            $(this.$el).val(this.selected !== null ? this.selected : 0).trigger('change');
        },
        watch: {
            'options.data'(data){
                $(this.$el).empty();
                $(this.$el).select2(this.options);
            },
            'selected'(selected){
                if(selected != $(this.$el).val()){
                    $(this.$el).val(selected !== null ? selected : 0).trigger('change');
                }
            }
        }
    }
</script>
