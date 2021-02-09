<template>
<div>
    <v-container fluid>
        <v-row justify="center">
            <h2 class="mt-5">PRODUCTS WITH OFFERS</h2>
        </v-row>
        <v-row class=" mt-5">
            <v-slide-group v-model="slide" class="pa-4" center-active show-arrows>
                <v-slide-item v-for="item in offers" :key="item.id" v-slot="{ toggle }">
                    <v-card max-width="300" class="ma-4" tile flat >
                        <v-hover v-slot="{ hover }">
                            <div style="overflow: hidden;">
                                <v-img :src="getImage(item)" width="300" height="350" style="transition: transform .4s;" :class="{ 'on-hover': hover }" @click="toggle">
                                    <v-slide-y-reverse-transition hide-on-leave>
                                        <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                            <v-row justify="center">
                                                <v-col cols="12" align="center"> 
                                                    <v-btn rounded color="white" class="text-capitalize mb-1" small @click="quickView(item)">Quick View</v-btn>
                                                    <div style="background-color:rgba(0,0,0,0.7)" class="mb-n2">
                                                        <v-rating v-model="rating" background-color="yellow" half-increments small color="orange"></v-rating>
                                                    </div>
                                                </v-col>
                                            </v-row>

                                        </div>
                                    </v-slide-y-reverse-transition>
                                </v-img>
                            </div>
                        </v-hover>
                        <v-card-actions class="pa-0">
                            <v-card-subtitle
                                class="pa-0 link"
                                @click="goToDetails(item)"
                            >
                                {{ item.title }}
                            </v-card-subtitle>

                            <v-spacer></v-spacer>
                            <v-btn icon v-if="wishlistItem.includes(item.id)">
                                <v-icon color="red" @click="alreadyMessage"
                                    >mdi-heart</v-icon
                                >
                            </v-btn>
                            <v-btn icon v-else>
                                <v-icon color="red" @click="addToWishlist(item)"
                                    >mdi-heart-outline</v-icon
                                >
                            </v-btn>
                        </v-card-actions>
                        <v-card-title class="pa-0">
                            price
                        </v-card-title>

                    </v-card>
                </v-slide-item>
            </v-slide-group>
        </v-row>
    </v-container>
</div>
</template>

<script>
import {
    mapState,
    mapMutations,
    mapActions
} from "vuex";
export default {
    data() {
        return {
            slide: null,
            offers: [],
            rating: 0
        };
    },
    computed: {
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        })
    },
    mounted() {
        this.getOffers();
    },
    methods: {
        ...mapActions(["goToDetails", "alreadyMessage"]),
        ...mapMutations([
            "pushToWishlist",
            "addToCart",
            "quickView",
            "addToWishlist"
        ]),

        getOffers() {
            axios
                .get("api/getProductOffers")
                .then(res => {
                    this.offers = res.data;
                })
                .catch(err => console.log(err.response));
        },

        getImage(item) {
            return item.image;
        }
    }
};
</script>
