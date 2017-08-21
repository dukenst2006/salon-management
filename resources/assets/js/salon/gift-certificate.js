import Vue from 'vue';
import axios from 'axios';
import moment from 'moment';
import Vuetify from 'vuetify';

Vue.use(Vuetify);

Object.defineProperty(Vue.prototype,'$axios',{value:axios});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});

axios.defaults.headers.common ={
    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

import GiftCertificate from '../components/salon/GiftCertificate.vue';

//console.log(Math.abs(window.orientation) === 90 ? 'landscape' : 'portrait');

Vue.component('app', GiftCertificate);
const app = new Vue({
    el: '#root',

});