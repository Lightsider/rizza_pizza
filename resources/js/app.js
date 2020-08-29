/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Object.defineProperty(Vue.prototype,"$eventBus",{
    get: function() {
        return this.$root.eventBus;
    }
});

Vue.component('cart-component', require('./components/CartComponent.vue').default);
Vue.component('add_to_cart-component', require('./components/AddToCartComponent.vue').default);
Vue.component('add_to_cart_icon-component', require('./components/AddToCartIconComponent.vue').default);
Vue.component('remove_from_cart_icon-component', require('./components/RemoveFromCartIconComponent').default);
Vue.component('cart_total-component', require('./components/CartTotalComponent').default);
Vue.component('cart_item_count-component', require('./components/CartItemCountComponent').default);

var eventBus = new Vue({});

const app = new Vue({
    el: '#app',
    data: {
        eventBus: eventBus
    }
});


