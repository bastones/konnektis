/**
 * Import the dependencies
 */
require('./bootstrap');

import router from './routes';

const app = new Vue({
    el: '#root',
    router
});
