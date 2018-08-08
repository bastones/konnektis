/**
 * Lodash Library
 */
window._ = require('lodash');

/**
 * jQuery Library
 */
window.$ = window.jQuery = require('jquery');

/**
 * PopperJS Library
 */
window.Popper = require('popper.js');

/**
 * Bootstrap Library
 */
require('bootstrap');

$('body').tooltip({
    selector: '[data-toggle="tooltip"]',
});

/**
 * Vue JS
 */
window.Vue = require('vue');

/**
 * Vue Router
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter);


/**
 * Vue Paginate
 */
import Paginate from 'vuejs-paginate';
Vue.component('paginate', Paginate);

/**
 * Axios Library
 */
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * CSRF Token
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found.');
}
