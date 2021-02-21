<template>
    <div>
       <v-container fluid class="px-10">
        <v-row justify="center">
            <h2 class="mt-5">Your Search Result</h2>
        </v-row>
        <v-row class=" mt-5" v-if="results.length>0">
                <v-col cols="12" lg="2" md="4" sm="6" v-for="item in results" :key="item.id">
                    <v-card max-width="300" class="mx-auto" tile flat>
                        <v-hover v-slot="{ hover }">
                            <div style="overflow: hidden;">
                                <v-img :src="getImage(item)" max-width="300" height="350" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                    <v-slide-y-reverse-transition hide-on-leave>
                                        <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                            <v-row justify="center">
                                                <v-col align="center" cols="12">
                                                    <v-btn rounded color="white" class="text-capitalize mb-1" small @click="quickView(item)">Quick View</v-btn>
                                                    <div style="background-color:rgba(0,0,0,0.7)" class="mb-n2">
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

        </v-row>
        <hollow-dots-spinner class="mx-auto my-16" v-else-if="results.length<1 && noResultText==''" :animation-duration="1000" :dot-size="20" :dots-num="3" color="#ff1d5e" />
<p
                v-else
                class="text--disabled mx-auto my-5 ml-5 position-absolute"
            >
                {{ noResultText }}
            </p>
    </v-container>
    </div>
</template>
<script>
import {
    HollowDotsSpinner
} from "epic-spinners";
import { mapState,mapMutations,mapActions } from 'vuex'
export default {
    components:{HollowDotsSpinner},
    data(){
        return{
            results:[],
            noResultText:'',
        }
    },
    computed:{
        ...mapState({
            searchText:state=>state.product.searchText,
            wishlistItem: state => state.product.wishlistItem,
        })
    },
    mounted(){
        this.getSearch()
    },
    methods:{
         ...mapActions(["goToDetails", "alreadyMessage"]),
        ...mapMutations([
            "pushToWishlist",
            "addToCart",
            "quickView",
            "addToWishlist"
        ]),
        getSearch(){
            axios.post('api/getSearch',{
                'text':this.searchText
            }).then(res=>{
                this.results=res.data
                if(this.results.length==0){
                    this.noResultText="No Items matched your search. Try different keyword."
                }
            })
            .catch(err=>console.log(err.response))
        }
    }
}
</script>