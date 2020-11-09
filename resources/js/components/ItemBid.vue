<template>
    
        <div  style="margin-top: auto;">
            <div v-if="(item.current_bidder > 0 || item.username == '')">
                <b>Bidder: </b><span class="text-muted mr-2 float-right"><mark :class="'bidder'+item.id" :id="'bidder'+item.id" :ref="'bidder'+item.id">{{ item.username }}</mark></span>
            </div>
            <div v-if="item.current_bid > 0">
                <b>Current Bid: </b><span class="text-success mr-2 float-right" :id="'bid'+item.id" :ref="'bid'+item.id">
                    ${{item.current_bid }}.00</span>
            </div>
            <div>
                <b>{{ item.current_bid == 0 ? 'Initial Bid: ' : 'Minimum Next Bid: '}}</b><span class="text-danger mr-2 float-right" :id="'next'+item.id" :ref="'next'+item.id">
                    ${{ item.current_bid == 0 ? item.initial_bid : item.current_bid + item.increment }}.00</span>
            </div>
        </div>
   
</template>
 <script>
 export default({
    props: {
        item: {
        type: Object,
        default: [],
        },
     },
     mounted() {
         //console.log(this.$refs);
     },
 })
 </script>
