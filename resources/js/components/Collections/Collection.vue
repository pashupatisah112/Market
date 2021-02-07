<template>
<div>
    <v-container>
        <v-row>
            <v-col cols="12" lg="2" md="3" v-for="item in collections" :key="item.id">
               <v-card max-width="300" class="mx-auto" tile flat>
                    <v-hover v-slot="{ hover }">
                        <div style="overflow: hidden;">
                            <v-img :src="getImage(item)" width="200" height="250" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                <v-slide-y-reverse-transition hide-on-leave>
                                    <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                        <v-col align="center">
                                            <v-btn rounded color="white" class="text-capitalize mb-1" small @click="quickView(item)">Quick View</v-btn>
                                            <div style="background-color:rgba(0,0,0,0.7)">
                                                <v-rating v-model="rating" background-color="yellow" half-increments small color="orange"></v-rating>
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
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
import {mapState,mapMutations,mapActions} from 'vuex';
export default {
    data() {
        return {
            collections: [],
            rating:0
        };
    },
    computed: {
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        }),
    },
    mounted() {
        this.getCollection();
    },
    methods: {
        ...mapActions(['goToDetails', 'alreadyMessage']),
        ...mapMutations(["pushToWishlist", 'addToCart', 'quickView', 'addToWishlist']),

        getCollection() {
            axios
                .get("api/getCollection")
                .then(res => {
                    this.collections = res.data
                    console.log(this.collections)
                })
                .catch(err => console.log(err.response));
        },

        getImage(item) {
            return item.image
        },

    }
};
</script>
