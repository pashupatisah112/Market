<template>
<div>
    <v-card width="300">
        <v-card-title>Your Cart</v-card-title>
        <v-container fluid>
            <v-row>
                <v-col cols="12">
                    <div v-if="cartlist.length>0">
                        <v-list two-line dense>
                            <v-list-item v-for="item in cartlist" :key="item.id" dense class="mt-n4">
                                <v-list-item-avatar tile size="60">
                                    <v-img :src="getImage(item)"></v-img>
                                </v-list-item-avatar>

                                <v-list-item-content>
                                    <v-list-item-title>{{item.title}}</v-list-item-title>
                                    <v-list-item-subtitle>{{item.cart.amount}} x Rs.{{item.price}}</v-list-item-subtitle>
                                </v-list-item-content>

                                <v-list-item-action>
                                    <v-btn icon small>
                                        <v-icon>
                                            mdi-cancel
                                        </v-icon>
                                    </v-btn>

                                </v-list-item-action>
                            </v-list-item>
                        </v-list>

                        <v-divider></v-divider>
                        <v-row class="mt-2 px-5">
                            <P class="text-h6">TOTAL:</P>
                            <v-spacer></v-spacer>
                            <p class="text-h6">Rs.2000</p>
                        </v-row>
                        <v-btn rounded block color="blackTheme" class="text-capitalize white--text" @click="viewCart">View Cart</v-btn>
                        <v-btn rounded block color="blackTheme" class="text-capitalize white--text my-3">Checkout</v-btn>
                    </div>
                    <hollow-dots-spinner
                class="mx-auto my-auto"
                v-else-if="wishlist.length < 1 && noCartText == ''"
                :animation-duration="1000"
                :dot-size="15"
                :dots-num="3"
                color="#ff1d5e"
            />
            <p
                v-else
                class="text--disabled mx-auto my-5 ml-5 position-absolute"
            >
                {{ noCartText }}
            </p>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</div>
</template>

<script>
import { HollowDotsSpinner } from "epic-spinners";

import {
    mapState,
    mapMutations
} from 'vuex';
export default {
    components:{},
    data() {
        return {
            noCartText:''
        }
    },
    computed: {
        ...mapState({
            cartlist: state => state.product.cartlist
        })
    },
    created() {
        this.getCart()
    },
    methods: {
        ...mapMutations(['cartList']),
        viewCart() {
            this.$router.push({
                name: 'Cart'
            })
        },
        getImage(item) {
            return "../storage/" + item.image
        },
        getCart(state) {
            axios.get("api/getCart")
                .then(res => {
                    this.cartList(res.data)
                    if(res.data.length<1){
                        this.noCartText='No cart items added.'
                    }
                })
                .catch(err => console.log(err.response))

        },
    }
}
</script>
