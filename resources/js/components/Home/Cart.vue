<template>
<div>
    <v-card width="300">
        <v-card-title>Your Cart</v-card-title>
        <v-container fluid>
            <v-row>
                <v-col cols="12">
                    <v-list two-line dense>
                        <v-list-item v-for="item in cartlist" :key="item.id" dense class="mt-n4">
                            <v-list-item-avatar tile size="60">
                                <v-img src="https://cdn.vuetifyjs.com/images/lists/1.jpg'"></v-img>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>{{item.title}}</v-list-item-title>
                                <v-list-item-subtitle>{{item.cart.amount}} x Rs.{{item.price}}</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action>
                                <v-icon>
                                    mdi-cancel
                                </v-icon>
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
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</div>
</template>

<script>
import {mapState} from 'vuex';
export default {
    data() {
        return {
        
        }
    },
    computed:{
        ...mapState({
            cartlist:state=>state.product.cartlist
        })
    },
    created(){
        console.log(this.cartlist)
    },
    methods:{
        viewCart() {
            this.$router.push({
                name: 'Cart'
            })
        },
    }
}
</script>
