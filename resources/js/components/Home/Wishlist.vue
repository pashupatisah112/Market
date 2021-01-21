<template>
    <div>
        <v-card width="400" min-height="200">
            <v-row class="px-5">
                <v-card-title class="float-left">Your Wishlist</v-card-title>
                <v-spacer></v-spacer>
                <v-card-subtitle class="float-right" v-if="wishlist.length > 0"
                    >View Similar</v-card-subtitle
                >
            </v-row>

            <v-container fluid v-if="wishlist.length > 0">
                <v-row>
                    <v-col cols="12">
                        <v-list two-line dense>
                            <v-list-item
                                v-for="item in wishlist"
                                :key="item.id"
                                dense
                                class="mt-n4"
                            >
                                <v-list-item-avatar tile size="60">
                                    <v-img src="../images/sample.png"></v-img>
                                </v-list-item-avatar>

                                <v-list-item-content>
                                    <v-list-item-title class="link" @click="goToDetails"
                                        v-text="item.title"
                                    ></v-list-item-title>
                                    <v-list-item-subtitle>{{
                                        item.price
                                    }}</v-list-item-subtitle>
                                </v-list-item-content>

                                <v-list-item-action>
                                    <v-row>
                                        <v-tooltip top>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    icon
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="addToCart(item)"
                                                >
                                                    <v-icon>
                                                        mdi-cart-plus
                                                    </v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Add to cart</span>
                                        </v-tooltip>
                                        <v-tooltip top>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    icon
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    @click="removeFromWishlist(item)"
                                                >
                                                    <v-icon>
                                                        mdi-close
                                                    </v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Remove</span>
                                        </v-tooltip>
                                    </v-row>
                                </v-list-item-action>
                            </v-list-item>
                        </v-list>
                    </v-col>
                </v-row>
            </v-container>
            <hollow-dots-spinner
                class="mx-auto my-auto"
                v-else-if="wishlist.length < 1 && noWishText == ''"
                :animation-duration="1000"
                :dot-size="15"
                :dots-num="3"
                color="#ff1d5e"
            />
            <p
                v-else
                class="text--disabled mx-auto my-5 ml-5 position-absolute"
            >
                {{ noWishText }}
            </p>
        </v-card>

    </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
import { mapState, mapMutations, mapActions } from "vuex";
import { mapFields } from "vuex-map-fields";

export default {
    components: {
        HollowDotsSpinner
    },
    data() {
        return {
            noWishText: ""
        };
    },
    computed: {
        ...mapState({
            wishlist: state => state.product.wishlist
        })
    },
    mounted() {
        this.getWishlist();
    },
    methods: {
        ...mapActions(['goToDetails']),
        ...mapMutations(["applyWishlist", "pullFromWishlist",'addToCart']),
        getWishlist() {
            axios
                .get("/api/getWishlist")
                .then(res => {
                    this.applyWishlist(res.data);
                    if (this.wishlist.length == 0) {
                        this.noWishText = "You have no wishlist item";
                    }
                })
                .catch(err => console.log(err.response));
        },
        removeFromWishlist(item) {
            this.pullFromWishlist(item);

            axios
                .post("api/removeFromWishlist", {
                    product_id: item.id
                })
                .then(res => {
                    this.$toast.success({
                        title: "Wishlist",
                        message: "Removed from your wishlist."
                    });
                })
                .catch(err => console.log(err.response));
        },
        getImage(item){
            return "../storage/"+item.image
        }
    }
};
</script>
