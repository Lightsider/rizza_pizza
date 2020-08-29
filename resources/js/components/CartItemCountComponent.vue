<template>
    <span>{{item_count}}</span>
</template>

<script>
    export default {
        props: ['id','count'],
        created(){
            let self = this;
            this.$eventBus.$on("change_cart_count", (data)=>{
                self.item_count = 0;
                data.items.forEach(function(item, i, arr) {
                    console.log(item);
                    if(item.product_id == self.id) {
                        self.item_count = item.quantity;
                        return;
                    }
                });

                if(self.item_count == 0) {
                    document.getElementById("product" + self.id).remove();
                }

                if(data.count < 1 && window.location.pathname != "/") {
                    window.location = "/";
                }
            });
        },
        data: function () {
            return {
                item_count: this.count,
            }
        }
    }
</script>
