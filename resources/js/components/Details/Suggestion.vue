<template>
<div>
    <v-container>
        <v-row>
            <p class="font-weight-bold">Similar Products</p>
            <v-col cols="12">
                <v-slide-group class="pa-4" center-active show-arrows>
                    <v-slide-item v-for="item in suggest" :key="item.id">
                        <v-card max-width="350" class="ma-4" tile flat>
                            <v-hover v-slot="{ hover }">
                                <div style="overflow: hidden;">
                                    <v-img :src="getImage(item)" width="200" height="250" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                        <v-slide-y-reverse-transition hide-on-leave>
                                            <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                                <v-col align="center">
                                                    <v-btn rounded color="white" class="text-capitalize mb-3" small @click="quickView(item)">Quick View</v-btn>
                                                    <div style="background-color:rgba(0,0,0,0.7)">
                                                        <v-rating v-model="rating" background-color="yellow" half-increments small color="orange" class="mt-n2"></v-rating>
                                                    </div>
                                                </v-col>
                                            </div>
                                        </v-slide-y-reverse-transition>
                                    </v-img>
                                </div>
                            </v-hover>
                            <v-card-actions class="pa-0">
                                <v-card-subtitle class="pa-0 link" @click="goToDetails(item)">
                                    {{ item.title }}
                                </v-card-subtitle>

                                <v-spacer></v-spacer>
                                <v-btn icon v-if="wishlistItem.includes(item.id)">
                                    <v-icon color="red" @click="alreadyMessage">mdi-heart</v-icon>
                                </v-btn>
                                <v-btn icon v-else>
                                    <v-icon color="red" @click="addToWishlist(item)">mdi-heart-outline</v-icon>
                                </v-btn>
                            </v-card-actions>
                            <v-card-title class="pa-0">
                                Rs.{{ item.price }}
                            </v-card-title>

                        </v-card>
                    </v-slide-item>
                </v-slide-group>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
import {
    mapState,
    mapActions,
    mapMutations
} from 'vuex'
export default {
    data() {
        return {
            suggest: [],
            product_code: this.$route.params.code,
            rating: 0
        }
    },
    computed: {
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        }),
    },
    mounted() {
        this.getSimilarProducts()
    },
    methods: {
        ...mapActions(['goToDetails', 'alreadyMessage']),
        ...mapMutations(["pushToWishlist", 'addToCart', 'quickView', 'addToWishlist']),
        getSimilarProducts() {
            axios.post('/api/getSimilarProducts', {
                code: this.product_code
            }).then(res => {
                this.suggest = res.data
                console.log('suggest:', this.suggest)
            }).catch(err => console.log(err.response))
        },
        getImage(item) {
            return "../storage/" + item.image
        },

    }
}
</script>
