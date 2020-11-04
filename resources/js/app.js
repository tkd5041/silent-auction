
const { default: Echo } = require('laravel-echo');

require('./bootstrap');

window.Vue = require('vue');

// for auto scroll
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

// for notifications
import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 3000})

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
});
