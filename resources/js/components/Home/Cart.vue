<template>
<div>
    <v-card width="300">
        <v-card-title>Your Cart</v-card-title>
        <v-container fluid>
            <v-row>
                <v-col cols="12">
                    <v-list two-line dense>
                        <v-list-item v-for="chat in items" :key="chat.title" dense class="mt-n4">
                            <v-list-item-avatar tile size="60">
                                <v-img :alt="`${chat.title} avatar`" :src="chat.avatar"></v-img>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title v-text="chat.title"></v-list-item-title>
                                <v-list-item-subtitle>1 x Rs.500</v-list-item-subtitle>
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
            items: [{
                    active: true,
                    avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
                    title: 'Jason Oner',
                },
                {
                    active: true,
                    avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
                    title: 'Mike Carlson',
                },
                {
                    avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
                    title: 'Cindy Baker',
                },
            ],
        }
    },
    computed:{
        // ...mapstate({
        //     cartlist:state=>state.product.cartlist
        // })
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
