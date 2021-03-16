<template>
<v-carousel cycle class="mt-4 hidden-sm-and-down">
    <v-carousel-item :show-arrows="arrows" v-for="(item,i) in featured" :key="i" src="https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg" reverse-transition="fade-transition" transition="fade-transition">
        <v-card color="transparent" max-width="500" flat style="position:absolute;left:5%;bottom:20%">
            <v-card-subtitle class="mb-n8 text-h6 text-uppercase">{{item.preTag}}</v-card-subtitle>
            <v-card-title class="text-h3 text-uppercase">{{item.promoTitle}}</v-card-title>
            <v-card-text>
                {{item.description}}
            </v-card-text>
            <v-card-actions>
                <v-btn rounded outlined dark width="150" class="text-capitalize" @click="goToDetails(item.product)">{{ $t('words.general.discoverMore') }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-carousel-item>
</v-carousel>
</template>

<script>
import {
    mapMutations,
    mapActions
} from 'vuex';
export default {
    data() {
        return {
            arrows: false,
            featured: [],
        }
    },
    computed: {
        artlistItem: state => state.product.cartlistItem

    },
    mounted() {
        this.getFeatured()
    },
    methods: {
        ...mapActions(['goToDetails']),
        ...mapMutations(['addToCart', 'addToCartlist']),
        getFeatured() {
            axios.get('api/getFeatured')
                .then(res => {
                    this.featured = res.data
                })
                .catch(err => console.log(err.response))
        },
       
    }
}
</script>
