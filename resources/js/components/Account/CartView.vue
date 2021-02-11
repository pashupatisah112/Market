<template>
<div>
    <v-container>
        <vue-khalti v-bind="khaltiConfig">
            <div @click="onKhaltiClick">khalti</div>
        </vue-khalti>
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
                        Subtotal: Rs. {{total}}
                    </v-card-text>

                    <v-divider class="mx-5"></v-divider>

                    <v-card-text>
                        <v-form v-model="valid" ref="form">
                            <p>Delivery addresss:</p>
                            <v-select dense :items="addresses" placeholder="Please choose" outlined :rules="[validRules.required]" class="mt-n3" @change="setupDeliveryCharge"></v-select>
                            <p>Location:</p>
                            <v-text-field placeholder="Your actual location" v-model="location" outlined dense :rules="[validRules.required]" class="mt-n3"></v-text-field>
                            <p>Location:</p>
                            <v-text-field placeholder="Your contact number" v-model="contact" outlined dense :rules="[validRules.required,validRules.length10]" class="mt-n3"></v-text-field>
                            <p>Delivery Charge: {{delivery_charge}}</p>
                        </v-form>

                        <v-divider></v-divider>

                        <p class="font-weight-bold">Total: {{net_total}}</p>

                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-btn rounded color="blackTheme" class=" mx-auto text-capitalize white--text" @click="confirmOrder()">Confirm order</v-btn>
                        </v-card-actions>

                        <p class="font-weight-bold">Note: If your outside kathmandu valley delivery charges may apply and may take 7-10 days for delivey. Customers inside valley will have free delivery charge and may get your order within 3 days</p>
                        <p class="text-center">Thank you for shopping with us.</p>
                    </v-card-text>

                </v-card>
            </v-col>
        </v-row>

        <!-- payment method dialog -->
        <v-dialog v-model="paymentDialog" persistent width="400px">
            <v-card>
                <v-card-title>Choose Payment Method</v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <v-radio-group v-model="paymentGroup" :rules="[validRules.required]">
                            <v-radio label="E-sewa" value="esewa"></v-radio>
                            <v-radio label="Khalti" value="khalti"></v-radio>
                            <v-radio label="Fonepay" value="fonepay"></v-radio>
                            <v-radio label="Cash On Delivery" value="cod"></v-radio>
                        </v-radio-group>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn rounded @click="paymentDialog=false" dark>Cancel</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn rounded dark @click="buy">Buy Now</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</div>
</template>

<script>
import {
    mapState
} from 'vuex';
import VueKhalti from 'vue-khalti';
import KhaltiCheckout from "khalti-checkout-web";

export default {
    components: {
        VueKhalti
    },
    data() {
        return {
            valid: true,
            net_total: 0,
            location: '',
            delivery_charge: 0,
            contact: '',
            carts: [],
            total: '',
            count: 1,
            addresses: ['Inside Kathmandu Valley', 'Outside Kathmandu Valley'],
            payment: ['Esewa', 'Khalti', 'Fonepay', 'Cash on delivery'],
            paymentDialog: false,
            paymentGroup: '',
            khaltiConfig: {
                "publicKey": "test_public_key_6371fd2fd0134e82a764511e20fd933f",
                "productIdentity": "12345678",
                "productName": "product",
                "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
                "amount": 1000,
                "eventHandler": {
                    onSuccess(payload) {
                        axios.post('api/verifyKhaltiPayment',{
                            'token':payload.token,
                            'amount':payload.amount
                        })
                        .then()
                        .catch(err=>console.log(err.response))
                    },
                    onError(error) {
                        console.log(error);
                    },
                    onClose() {
                        console.log('widget is closing');
                    }
                }
            },

        }
    },
    mounted() {
        this.getCartDetail()
    },
    computed: {
        ...mapState({
            validRules: state => state.validation.validRules,
            cartlist:state=>state.product.cartlist,
            auth:state=>state.authentication.auth
        })
    },

    methods: {
        getCartDetail() {
            axios.get('api/getCartDetail')
                .then(res => {
                    this.carts = res.data.product
                    this.total = res.data.total
                })
                .catch(err => console.log(err.response))
        },
        getCount(item) {
            this.count = item.cart[0].amount
        },
        getImage(item) {
            return item.image
        },
        confirmOrder() {
            if (this.$refs.form.validate()) {
                this.paymentDialog = true
            }
        },
        setupDeliveryCharge(e) {
            if (e == 'Outside Kathmandu Valley') {
                this.delivery_charge = 100
            } else {
                this.delivery_charge = 0
            }
            this.net_total = this.delivery_charge + this.total
        },
        buy() {
            if (this.$refs.form.validate()) {
                db.collection("notification").add({
                    user_name:this.auth.name,
                    type:'order',
                    item_num: this.cartlist.length,
                    created_at:new Date(),
                    read_at:null,
                })
                .then(
                    console.log('ordered')
                )
                .catch(function (error) {
                    console.error("Error adding document: ", error);
                });
            }
        },
        onKhaltiClick() {
            let checkout = new KhaltiCheckout(this.khaltiConfig);
            const khaltiCheckout = this.$refs.khaltiCheckout
            //khaltiCheckout.onClick()
            checkout.show({
                amount: 1000
            });
        }
    }
}
</script>
