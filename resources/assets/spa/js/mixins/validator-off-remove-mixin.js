export default{
    beforeDestroy(){
        this.$off('VALIDATOR_OFF');
    }
}