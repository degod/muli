/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.flash = function(message) {
    window.events.$emit('flash', message);
}
import VueRouter from 'vue-router'

Vue.use(VueRouter)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('my-component', require('./components/ExampleComponent.vue'));
const routes = [{
    path: "/",
    component: require('./components/LoginComponent.vue'),
}, {
    path: "/index",
    component: require('./components/IndexComponent.vue'),
}, {
    path: "/store",
    component: require('./components/StoreComponent.vue'),
}, {
    path: "/cart",
    component: require('./components/CartComponent.vue'),
}, {
    path: "/404",
    component: require('./components/NotFoundComponent.vue'),
}, ];

Vue.component('flash', require('./components/FlashComponent.vue'));

const router = new VueRouter({
    routes
})
const app = new Vue({
    el: '#vue-app',
    router
});