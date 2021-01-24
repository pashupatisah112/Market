<template>
    <div>
        <v-container fluid>
            <v-row justify="center">
                <h2 class="mt-5">LATEST PRODUCTS</h2>
            </v-row>
            <v-row class=" mt-5">
                <v-col
                    cols="12"
                    lg="3"
                    md="3"
                    v-for="item in latest"
                    :key="item.id"
                >
                    <v-card max-width="300" class="mx-auto" tile flat>
                        <v-hover v-slot="{ hover }">
                            <div style="overflow: hidden;">
                                <v-img
                                    :src="getImage(item)"
                                    width="300"
                                    height="350"
                                    style="transition: transform .4s;"
                                    :class="{ 'on-hover': hover }"
                                >
                                    <v-slide-y-reverse-transition hide-on-leave>
                                        <div
                                            v-if="hover"
                                            class="d-flex transition-fast-in-fast-out v-card--reveal"
                                            style="height: 30%;"
                                        >
                                            
                                            <v-btn
                                                rounded
                                                color="white"
                                                class="text-capitalize"
                                                small
                                                @click="quickView(item)"
                                                >Quick View</v-btn
                                            >
                                        </div>
                                    </v-slide-y-reverse-transition>
                                </v-img>
                            </div>
                        </v-hover>
                        <v-card-actions class="pa-0">
                            <v-card-subtitle
                                class="pa-0 link"
                                @click="goToDetails"
                            >
                                {{ item.title }}
                            </v-card-subtitle>

                            <v-spacer></v-spacer>
                            <v-btn icon v-if="wishlistItem.includes(item.id)">
                                <v-icon
                                    color="red"
                                    @click="alreadyMessage"
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
                            Rs.{{ item.price }}
                        </v-card-title>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import { mapFields } from "vuex-map-fields";
export default {
    data() {
        return {
            latest: []
        };
    },
    computed: {
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        }),
    },
    mounted() {
        this.getLatest();
    },
    methods: {
        ...mapActions(['goToDetails','alreadyMessage']),
        ...mapMutations(["pushToWishlist",'addToCart','quickView','addToWishlist']),
        
        getLatest() {
            axios
                .get("api/latestProducts")
                .then(res => {
                    this.latest = res.data;
                })
                .catch(err => console.log(err.response));
        },
        
        
        getImage(item){
            return "../storage/"+item.image
        },

    }
};
</script>
