/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

<<<<<<< HEAD
Vue.component('current-bids', require('./components/CurrentBids.vue').default);
Vue.component('item-bid', require('./components/ItemBid.vue').default);

const app = new Vue({
    el: '#app',
    data:{
        bids: [],
        numberOfUsers:0
    },
    methods:{
        //
    },
    mounted(){
        window.Echo.channel('bids')
            .listen('NewBid', (e) => {
                console.log(e)
            });
        window.Echo.join('bids')
            .here((users) => {
                this.numberOfUsers = users.length;
                //console.log(bids);
            })
            .joining((user) => {
                 this.numberOfUsers += 1;
                // this.$toaster.info(user.name+' has joined the room.');
            })
            .leaving((user) => {
                 this.numberOfUsers -= 1;
                // this.$toaster.warning(user.name+' has left the room.');
            });
    }
=======
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
>>>>>>> parent of d794874... websockets update 20201101-2100
});
