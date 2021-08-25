window._ = require('lodash');


try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}



window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.toast = require('jquery-toast-plugin');
window.dataTable = require('datatables.net');
window.dataTabledt = require('datatables.net-dt');



