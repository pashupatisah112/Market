<template>
    <div>
        <v-container>
            <v-row justify="center">
                <p class="text-h6 font-weight-bold">{{$t('words.general.productCollect')}}</p>
            </v-row>
            <v-row v-if="collections.data" justify="center">
                <v-col
                    cols="12"
                    lg="3"
                    md="4"
                    sm="6"
                    v-for="item in collections.data"
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
                                            <v-row justify="center">
                                                <v-col align="center">
                                                    <v-btn
                                                        rounded
                                                        color="white"
                                                        class="text-capitalize mb-1"
                                                        small
                                                        @click="quickView(item)"
                                                        >{{$t('words.general.quickView')}}</v-btn
                                                    >
                                                    <div
                                                        style="background-color:rgba(0,0,0,0.7)"
                                                        class="mb-3"
                                                    >
                                                        <v-rating
                                                            :value="
                                                                getRating(item)
                                                            "
                                                            background-color="yellow"
                                                            half-increments
                                                            small
                                                            color="orange"
                                                        ></v-rating>
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
                            Rs.{{ item.price }}
                        </v-card-title>
                    </v-card>

                    
                </v-col>
                <v-pagination
                        v-model="page"
                        :length="collections.last_page"
                        prev-icon="mdi-menu-left"
                        next-icon="mdi-menu-right"
                        :total-visible="7"
                        @input="input"
                        @next="next"
                        @previous="previous"
                        class="my-5"
                    ></v-pagination>
            </v-row>
            <hollow-dots-spinner
                class="mx-auto my-16"
                v-else
                :animation-duration="1000"
                :dot-size="20"
                :dots-num="3"
                color="#ff1d5e"
            />
            <v-row justify="center"> </v-row>
        </v-container>
    </div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";
import { mapState, mapMutations, mapActions } from "vuex";
export default {
    components: {
        HollowDotsSpinner
    },
    data() {
        return {
            collections: "",
            rating: 0,
            page: 1
        };
    },
    computed: {
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        })
    },
    mounted() {
        this.getCollection();
    },
    methods: {
        ...mapActions(["goToDetails", "alreadyMessage"]),
        ...mapMutations([
            "pushToWishlist",
            "addToCart",
            "quickView",
            "addToWishlist"
        ]),

        getCollection() {
            axios
                .get("api/getCollection?page=" + this.page)
                .then(res => {
                    this.collections = res.data;
                    console.log(this.collections.data.length);
                })
                .catch(err => console.log(err.response));
        },

        getImage(item) {
            return item.image;
        },
        getRating(item) {
            let rate = 0;
            for (var i = 0; i < item.rating.length; i++) {
                rate = rate + parseInt(item.rating[i].rating);
            }
            return rate / item.rating.length;
        },
        input(e) {
            this.page = e;
            this.getCollection();
        },
        next(e) {
            axios
                .get(this.collections.next_page_url)
                .then(res => {
                    this.collections = res.data;
                })
                .catch(err => console.log(err.response));
        },
        previous() {
            axios
                .get(this.collections.previous_page_url)
                .then(res => {
                    this.collections = res.data;
                })
                .catch(err => console.log(err.response));
        }
    }
};
</script>
