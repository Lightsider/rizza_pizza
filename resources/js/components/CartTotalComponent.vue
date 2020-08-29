<template>
    <span>{{cart_total}} {{cart_currency}}</span>
</template>

<script>
    export default {
        props: ['total','currency'],
        created(){
            let self = this;
            this.$eventBus.$on("change_cart_count", (data)=>{
                self.cart_total = data.total;
                self.cart_currency = data.currency;
            });
        },
        data: function () {
            console.log(this);
            return {
                cart_total: this.total,
                cart_currency: this.currency,
            }
        }
    }
</script>
