<template>
    <div :v-bind="item-bid-item.id">
        <p v-if="current_bid == 0">
            <b>Minimum Bid: </b>
            <span class="text-danger">${{ initial_bid }}.00</span>
        </p>
        <p v-else>
            <b>Bidder: </b>
            <span class="text-muted ml-1"><mark> {{ username }} </mark></span><br>
            <b>Current Bid: </b>
            <span class="text-success ml-2">${{ current_bid }}.00</span><br>
            <b>Minimum Bid: </b>
            <span class="text-danger">
                ${{ current_bid + increment }}.00
            </span>
        </p>
    </div>
</template>
<script>
export default({
    props: {
        items: {
        type: Array,
        default: [],
        },
    },
})
</script>
