<template>
<div>
    
    <carousel></carousel>
    <latest></latest>
    <recommend></recommend>
    <!-- <topSelling></topSelling> -->
    <!-- <productOffers></productOffers> -->
</div>
</template>

<script>
import Carousel from '../Home/Carousel';
import Latest from '../Home/LatestProducts';
import TopSelling from '../Home/TopProducts';
import Recommend from '../Home/Recommended';
// import ProductOffers from '../Home/ProductOffers';
export default {
    components: {
        Carousel,
        Latest,
        Recommend,
        TopSelling
    },
    data() {
        return {

        }
    }
}
</script>
