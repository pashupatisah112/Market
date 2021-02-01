<template>
<div>
    <v-container>
        <v-row justify="center">
            <p class="text-h4">Your cart</p>
        </v-row>
        <v-row>
            <v-col cols="8">
                <v-simple-table class="border">
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Product
                                </th>
                                <th class="text-left">
                                    Color
                                </th>
                                <th class="text-left">
                                    Size
                                </th>
                                <th class="text-left">
                                    Price
                                </th>
                                <th class="text-left">
                                    Quantity
                                </th>
                                <th class="text-left">
                                    Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in carts" :key="item.id">
                                <td>
                                    <v-list two-line dense>
                                        <v-list-item>
                                            <v-list-item-avatar tile size="60">
                                                <v-img :alt="`${item.title} avatar`" :src="getImage(item.product[0])"></v-img>
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title v-text="item.product[0].title"></v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                </td>
                                <td>{{item.color.color_name}}</td>
                                <td>{{item.size.size}}</td>
                                <td>{{item.product[0].price}}</td>
                                <td>
                                    {{item.amount}}
                                </td>
                                <td>{{count*item.product[0].price}}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-col>
            <v-col cols="4">
                <v-card outlined flat>
                    <v-card-title>
                        CART TOTALS
                    </v-card-title>

                    <v-card-text>
                        Subtotal: Rs.5000
                    </v-card-text>

                    <v-divider class="mx-5"></v-divider>

                    <v-card-text>
                        <p>Delivery Charge: 100</p>
                        <p>Delivery address: Kadaghari, suncity</p>
                        <p>Contact Number: 9815790619</p>

                        <v-divider></v-divider>

                        <p class="font-weight-bold">Total: Rs.8000</p>

                        <v-divider></v-divider>

                        <p class="font-weight-bold">Note: If your outside kathmandu valley delivery charges may apply and may take 7-10 days for delivey. Customers inside valley will have free delivery charge and may get your order within 3 days</p>
                        <p class="text-center">Thank you for shopping with us.</p>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn rounded color="blackTheme" class=" mx-auto text-capitalize white--text">Confirm order</v-btn>
                    </v-card-actions>

                </v-card>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
import { mapState } from 'vuex'
export default {
    data() {
        return {
            carts:[],
            total:'',
            count: 1,
        }
    },
    mounted(){
        this.getCartDetail()
    },
    
    methods: {
        getCartDetail(){
            axios.get('api/getCartDetail')
            .then(res=>{
                this.carts=res.data.product
                this.total=res.data.total
                console.log(this.carts)
            })
            .catch(err=>console.log(err.response))
        },
        getCount(item){
            this.count=item.cart[0].amount
        },
        getImage(item){
            return "../storage/"+item.image
        }
    }
}
</script>
