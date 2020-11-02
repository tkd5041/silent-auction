<template>
    <div class="current-bids">
        <LatestBids :bids="bids" />
    </div>
</template>
<script>
import LatestBids from './LatestBids';
export default {
    data() {
        return {
            bids: [],
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
                this.bids = e.bids;
                //console.log(e.bids);
            });
    },
    components: {
        LatestBids
    }
}
</script>