<template>
<div>
    <v-container fluid>
        <v-row v-if="sale">
             <v-col cols="12" lg="2" md="4" sm="6" v-for="item in sale.data" :key="item.id">
                    <v-card max-width="200" class="mx-auto" tile flat>
                        <v-hover v-slot="{ hover }">
                            <div style="overflow: hidden;">
                                <v-img :src="getImage(item)" max-width="200" height="250" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                    <v-slide-y-reverse-transition hide-on-leave>
                                        <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                            <v-row justify="center">
                                                <v-col align="center" cols="12">
                                                    <v-btn rounded color="white" class="text-capitalize mb-1" small @click="quickView(item)">{{$t('words.general.quickView')}}</v-btn>
                                                    <div style="background-color:rgba(0,0,0,0.7)" class="mb-3">
                                                        <v-rating :value="getRating(item)" readonly background-color="yellow" half-increments small color="orange"></v-rating>
                                                    </div>
                                                </v-col>
                                            </v-row>
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
                <v-col cols="12" align="center">
                <v-pagination
                        v-model="page"
                        :length="sale.last_page"
                        prev-icon="mdi-menu-left"
                        next-icon="mdi-menu-right"
                        :total-visible="7"
                        @input="input"
                        @next="next"
                        @previous="previous"
                        class="my-5"
                    ></v-pagination>
            </v-col>
        
        </v-row>
        <hollow-dots-spinner class="mx-auto my-16" v-else-if="sale.data.length <1 && noProdText==''" :animation-duration="1000" :dot-size="20" :dots-num="3" color="#ff1d5e" />
        <p v-else class="text-center text-secondary">{{noProdText}}</p>
    </v-container>
</div>
</template>

<script>
import {
    HollowDotsSpinner
} from "epic-spinners";
import {mapState,mapMutations,mapActions} from 'vuex';
export default {
    components:{HollowDotsSpinner},
    data() {
        return {
            sale: [],
            noProdText:'',
            rating:0,
            page:1,
        };
    },
    computed: {
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        }),
    },
    mounted() {
        this.getSale();
    },
    methods: {
        ...mapActions(['goToDetails', 'alreadyMessage']),
        ...mapMutations(["pushToWishlist", 'addToCart', 'quickView', 'addToWishlist']),

        getSale() {
            axios
                .get("api/getSale?page="+this.page)
                .then(res => {
                    this.sale = res.data
                    if(res.data.data.length<1){
                        this.noProdText='No items is sale. Come back later.'
                    }
                })
                .catch(err => console.log(err.response));
        },

        getImage(item) {
            return item.image
        },
         getRating(item) {
            let rate = 0
            for (var i = 0; i < item.rating.length; i++) {
                rate = rate + parseInt(item.rating[i].rating)

            }
            return rate / item.rating.length
        },
         input(e) {
            this.page = e;
            this.getSale();
        },
        next(e) {
            axios
                .get(this.sale.next_page_url)
                .then(res => {
                    this.sale = res.data;
                })
                .catch(err => console.log(err.response));
        },
        previous() {
            axios
                .get(this.sale.previous_page_url)
                .then(res => {
                    this.sale = res.data;
                })
                .catch(err => console.log(err.response));
        }

    }
};
</script>
