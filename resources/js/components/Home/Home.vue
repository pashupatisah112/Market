<template>
<div>
    
    <carousel></carousel>
    <latest></latest>
    <topSelling></topSelling>
    <productOffers></productOffers>
</div>
</template>

<script>
import Carousel from '../Home/Carousel';
import Latest from '../Home/LatestProducts';
import TopSelling from '../Home/TopProducts';
import ProductOffers from '../Home/ProductOffers';
export default {
    components: {
        Carousel,
        Latest,
        TopSelling,
        ProductOffers,
    },
    data() {
        return {

        }
    }
}
</script>
