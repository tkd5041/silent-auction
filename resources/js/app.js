require('./bootstrap');

window.Vue = require('vue');

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

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
                this.$toaster.info(user.name+' has joined the room.');
            })
            .leaving((user) => {
                 this.numberOfUsers -= 1;
                this.$toaster.warning(user.name+' has left the room.');
            });
        }

});


