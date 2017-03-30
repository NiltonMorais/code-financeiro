<template>
    <div :id="modal.id" class="modal">
        <div class="modal-content">
            <slot name="content"></slot>
        </div>
        <div class="modal-footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: {
            modal: {
                type: Object,
                default(){
                    return {
                        id: ''
                    }
                }
            }
        },
        ready(){
            let id = this.modal.id;
            $(document).ready(() => {
                $(`#${id}`).modal();
            });
        }
    };
</script>

