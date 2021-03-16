<template>
<div>
    <v-container fluid>
        <v-row justify="center">
            <p class="text-h4">{{$t('words.general.topSeller')}}</p>
        </v-row>
        <v-row>
            <v-col cols="12" lg="10">
                <v-row justify="center" class="my-3">
                    <v-chip v-for="item in categories" :key="item.id" class="mx-2" @click="filterTop(item)" link>{{item.subCategory_name}}</v-chip>
                </v-row>
                <v-row class="px-10" v-if="topSeller.data">
                    <v-col cols="12" lg="3" md="4" sm="6" v-for="item in topSeller.data" :key="item.id">
                        <v-card max-width="300" class="mx-auto" tile flat>
                            <v-hover v-slot="{ hover }">
                                <div style="overflow: hidden;">
                                    <v-img :src="getImage(item)" width="300" height="350" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                        <v-slide-y-reverse-transition hide-on-leave>
                                            <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                                <v-row justify="center">
                                                    <v-col align="center" cols="12">
                                                        <v-btn rounded color="white" class="text-capitalize mb-1" small @click="quickView(item)">Quick View</v-btn>
                                                        <div style="background-color:rgba(0,0,0,0.7)" class="mb-n2">
                                                            <v-rating :value="getRating(item)" background-color="yellow" half-increments small color="orange"></v-rating>
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
                        :length="topSeller.last_page"
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
                <hollow-dots-spinner class="mx-auto my-16" v-else :animation-duration="1000" :dot-size="20" :dots-num="3" color="#ff1d5e" />

            </v-col>
            <v-col cols="12" lg="2">
                <p class="text-h6 text-center">{{$t('words.general.topBrand')}}</p>
                <v-chip v-for="item in topBrands" :key="item.id" class="mx-2" @click="fromTopBrands(item)" link>{{item.company_name}}</v-chip>

            </v-col>
        </v-row>

    </v-container>
</div>
</template>

<script>
import {
    mapState,
    mapMutations,
    mapActions
} from 'vuex';
import {
    HollowDotsSpinner
} from "epic-spinners";
export default {
    components: {
        HollowDotsSpinner
    },
    data() {
        return {
            page:1,
            topSeller: [],
            categories: [],
            rating: 0,
            topBrands: []
        };
    },
    computed: {
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        }),
    },
    mounted() {
        this.getTopSellers();
        this.getTopCategory();
    },
    methods: {
        ...mapActions(['goToDetails', 'alreadyMessage']),
        ...mapMutations(["pushToWishlist", 'addToCart', 'quickView', 'addToWishlist']),

        getTopCategory() {
            axios
                .get("api/getTopCategory")
                .then(res => {
                    this.categories = res.data
                })
                .catch(err => console.log(err.response));
        },
        getTopSellers() {
            axios
                .post("api/getTopSellers?page=" + this.page)
                .then(res => {
                    this.topSeller = res.data.product
                    this.topBrands = res.data.company
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
        filterTop(item) {
            axios.post('api/filterTopCategories', {
                    sub_cat_id: item.id
                })
                .then(res => this.topSeller = res.data)
                .catch(err => console.log(err.response))
        },
        fromTopBrands(item){
            axios.post('api/fromTopBrands',{
                company_id:item.id
            }).then(res=>this.topSeller=res.data)
            .catch(err=>console.log(err.response))
        },
        input(e) {
            this.page = e;
            this.getTopSellers();
        },
        next(e) {
            axios
                .get(this.topSeller.next_page_url)
                .then(res => {
                    this.topSeller = res.data.product;
                })
                .catch(err => console.log(err.response));
        },
        previous() {
            axios
                .get(this.topSeller.previous_page_url)
                .then(res => {
                    this.topSeller = res.data.product;
                })
                .catch(err => console.log(err.response));
        }
    }
};
</script>
