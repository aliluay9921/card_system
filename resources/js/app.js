require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

import vSelect from 'vue-select'

import 'vue-select/dist/vue-select.css';

Vue.component('v-select', vSelect);
