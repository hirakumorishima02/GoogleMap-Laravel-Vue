/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import Navbar from './components/Navbar.vue';
import Map from './components/Map.vue';
import Detail from './components/Detail.vue';


import VueRouter from 'vue-router';
Vue.use(VueRouter);
const router = new VueRouter({
    routes:[
        { path:'/', component: Map, name:'map' },
        { path:'/:id', component: Detail, name:'detail' },
    ]
});

Vue.component('navbar', Navbar);


const app = new Vue({
    el: '#app',
    router
}).$mount(console.log('mounted'));
