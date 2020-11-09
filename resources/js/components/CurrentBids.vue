<template>
    <div class="current-bids">
        <LatestBids :bids="bids" />
    </div>
</template>
<script>
import LatestBids from './LatestBids';

import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 6000})

export default {
    data() {
        return {
            bids: [],
            item: [],
        };
    },
    mounted() {
        axios.get('/bids')
        .then((response) => {
            this.bids = response.data;
        //console.log(response);
        });
        window.Echo.channel('bids')
            .listen('NewBid', (e) => {
                // update latest bids
                this.bids = e.bids;

                // notify everyone of new bid
                this.$toaster.info(e.bids[0].username+' has bid $'+e.bids[0].current_bid+'.00 on item: '+e.bids[0].title+'!');
                
                // get data on item so we can update the item to the new bidder information
                axios.get('/item/'+e.bids[0].item_id)
                    .then ((response) => {
                        var id = 'item'+response.data.id;
                        var br = 'bidder'+response.data.id;
                        var bd = 'bid'+response.data.id;
                        var nt = 'next'+response.data.id;
                        var bidder = e.bids[0].username;
                        var bid = response.data.bid;
                        var next = response.data.next;
                        console.log(id, br, bd, nt, bidder, bid, next);
                        this.$refs.bd.innerHTML = e.bids[0].username;
                        document.getElementById(bd).innerHTML = bid;
                        document.getElementById(nt).innerHTML = next;
                    });
            });
    },
    components: {
        LatestBids
    }
}
</script>