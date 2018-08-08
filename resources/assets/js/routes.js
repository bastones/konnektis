import VueRouter from 'vue-router';

let routes = [
    {
        path: '*',
        redirect: '/',
    },

    {
        path: '/',
        name: 'home',
        component: require('./views/Home.vue'),
    },
];

export default new VueRouter({
    mode: 'history',
    routes,
});
