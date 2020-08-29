<template>
    <i :href="link" v-on:click="addToCart" class="material-icons" style="font-size: 18px; cursor: pointer">remove</i>
</template>

<script>
    import AddToCartComponent from './AddToCartComponent';

    export default {
        props: ['link'],
        mixins: [AddToCartComponent],
    }
</script>
