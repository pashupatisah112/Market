<template>
<div>
    <v-app>
        <appbar app></appbar>
        <carousel app></carousel>
        <latest></latest>
    </v-app>
</div>
</template>

<script>
import Appbar from './Home/Appbar';
import Carousel from './Home/Carousel';
import Latest from './Home/LatestProducts';
export default {
    components: {
        Appbar,Carousel,Latest
    },
    data() {
        return {

        }
    }
}
</script>
