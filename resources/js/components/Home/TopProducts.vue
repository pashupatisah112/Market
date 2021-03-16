<template>
<div>
    <v-container>
        <v-row justify="center">
            <h2 class="mt-5 text-uppercase">{{ $t('words.general.topSellingProducts') }}</h2>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-chip v-for="item in categories" :key="item.id" class="mx-2" @click="filterTop(item)" link>{{item.subCategory_name}}</v-chip>
        </v-row>
        <v-row class=" mt-5" justify="center" v-if="this.top.length>0">
            <v-col cols="12" lg="2" md="4" sm="6" v-for="item in top" :key="item.id" align="center">
                <v-card max-width="200" class="border" tile flat>
                    <v-hover v-slot="{ hover }">
                        <div style="overflow: hidden;">
                            <v-img :src="getImage(item)" max-width="200" height="250" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                <v-slide-y-reverse-transition hide-on-leave>
                                    <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                        <v-row justify="center">
                                        <v-col cols="12" align="center">
                                            <v-btn rounded color="white" class="text-capitalize mb-1" small @click="quickView(item)">{{$t('words.general.quickView')}}</v-btn>
                                            <div style="background-color:rgba(0,0,0,0.7)" class="mb-3">
                                                <v-rating readonly :value="getRating(item)" background-color="yellow" half-increments small color="orange"></v-rating>
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

        </v-row>
        <hollow-dots-spinner class="mx-auto my-16" v-else :animation-duration="1000" :dot-size="20" :dots-num="3" color="#ff1d5e" />

    </v-container>
</div>
</template>

<script>
import {
    mapState,
    mapMutations,
    mapActions
} from "vuex";
import {
    HollowDotsSpinner
} from "epic-spinners";
export default {
    components: {
        HollowDotsSpinner
    },
    data() {
        return {
            categories: [],
            top: [],
            rating: 0
        }
    },
    computed: {
        ...mapState({
            wishlistItem: state => state.product.wishlistItem
        }),
    },
    mounted() {
        this.getTopProducts();
        this.getTopCategory()
    },
    methods: {
        ...mapActions(['goToDetails', 'alreadyMessage']),
        ...mapMutations(["pushToWishlist", 'addToCart', 'quickView', 'addToWishlist']),
        getTopCategory(){
            axios
                .get("api/getTopCategory")
                .then(res => {
                    this.categories=res.data
                })
                .catch(err => console.log(err.response));
        },
        getTopProducts() {
            axios
                .get("api/getTopProducts")
                .then(res => {
                    this.top = res.data;
                })
                .catch(err => console.log(err.response));
        },

        getImage(item) {
            return item.image
        },
        filterTop(item){
            axios.post('api/filterTopCategories',{
                sub_cat_id:item.id
            })
            .then(res=>this.top=res.data)
            .catch(err=>console.log(err.response))
        },
        getRating(item){
            let rate=0
            for(var i=0;i<item.rating.length;i++){
                rate=rate+parseInt(item.rating[i].rating)
                
            } 
            return rate/item.rating.length
        }
    }
}
</script>
