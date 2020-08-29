<template>
    <a :href="link" v-on:click="addToCart" class="btn btn-primary">Add cart</a>
</template>

<script>
    export default {
        props: ['link'],
        methods: {
            addToCart: function(e) {
                e.preventDefault();
                let link = e.target.getAttribute("href");
                let self = this;

                axios
                    .post(link,
                        {})
                    .then(function (response) {
                        self.$eventBus.$emit("change_cart_count", response.data.data);
                        alert(response.data.message);
                    }).catch(function (error) {
                    alert(error.message);
                    console.log(error);
                });

            }
        }
    }
</script>
