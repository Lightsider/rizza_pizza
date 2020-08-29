<template>
    <i :href="link" v-on:click="addToCart" class="material-icons" style="font-size: 18px;cursor: pointer">add</i>
</template>

<script>
    import AddToCartComponent from './AddToCartComponent';

    export default {
        mixins: [AddToCartComponent],
    }
</script>
