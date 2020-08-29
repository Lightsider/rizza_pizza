<template>
    <div class="container">
        <i class="material-icons">shopping_cart</i><span class="notification" style="font-size: 13px;">{{count}}</span>  Cart
    </div>
</template>

<script>
    export default {
        props: ['cart_count'],
        created(){
            let self = this;
            this.$eventBus.$on("change_cart_count", (data)=>{
                self.count = data.count;
            });
        },
        data: function () {
            return { count: this.cart_count}
        }
    }
</script>
