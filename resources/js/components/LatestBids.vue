<template>
  <div class="latest-bids" v-if="bids != ''">
    <div class="bids" v-for="bid in bids" :key="bid.id">
      <h6>{{ bid.title }}</h6>
      <h6 class="text-muted ml-2">
        by <mark> {{ bid.username }} </mark>
      </h6>
      <p class="text-muted ml-2">
        for
        <span class="text-success">${{ bid.current_bid }}.00</span>
        <cite>{{ formatTime(bid.created_at) }}</cite>
      </p>
      <hr>
    </div>
  </div>
  <div v-else>
<h4 class="text-center text-info">No Bids Yet</h4>
  </div>
</template>
<script>
import moment from 'moment'
export default {
  props: {
    bids: {
      type: Array,
      default: [],
    },
  },
  methods: {
      formatTime($d){
        //console.log('before: ', $d)
          $d = moment($d); //.subtract(7, 'hours');
        //console.log('after: ', $d);
         return moment($d).fromNow();
      }
  }
};
</script>
