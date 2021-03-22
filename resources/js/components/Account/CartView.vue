<template>
<div>
    <v-container>
        <!-- <vue-khalti v-bind="khaltiConfig">
            <div @click="onKhaltiClick">khalti</div>
        </vue-khalti> -->
        <v-row justify="center">
            <p class="text-h4">{{$t('words.general.yourCart')}}</p>
        </v-row>
        <v-row>
            <v-col cols="8">
                <v-simple-table class="border">
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    {{ $t('words.general.product')}}
                                </th>
                                <th class="text-left">
                                    {{$t('words.detail.color')}}
                                </th>
                                <th class="text-left">
                                    {{$t('words.detail.size')}}
                                </th>
                                <th class="text-left">
                                    {{$t('words.filter.price')}}
                                </th>
                                <th class="text-left">
                                    {{$t('words.general.quantity')}}
                                </th>
                                <th class="text-left">
                                    {{$t('words.general.amount')}}
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
                                <td><span v-if="item.color">{{item.color.color_name}}</span><span v-else>-</span></td>
                                <td><span v-if="item.size">{{item.size.size}}</span><span v-else>-</span></td>
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
                        {{$t('words.general.cartTotal')}}
                    </v-card-title>

                    <v-card-text>
                        {{$t('words.general.subTotal')}}: {{$t('words.filter.rs')}}. {{total}}
                    </v-card-text>

                    <v-divider class="mx-5"></v-divider>

                    <v-card-text>
                        <v-form v-model="valid" ref="form">
                            <p>{{$t('words.general.deliveryAddress')}}:</p>
                            <v-select dense :items="addresses" :placeholder="$t(placeChoose())" outlined :rules="[validRules.required]" class="mt-n3" @change="setupDeliveryCharge"></v-select>

                            <p>{{$t('words.general.location')}}:</p>
                            <v-text-field :placeholder="$t(placeLocation())" v-model="location" outlined dense :rules="[validRules.required]" class="mt-n3"></v-text-field>

                            <p>{{$t('words.general.contactNum')}}:</p>
                            <v-text-field :placeholder="$t(placeContact())" v-model="contact" outlined dense :rules="[validRules.required,validRules.length10]" class="mt-n3"></v-text-field>
                            <p>{{$t('words.general.deliveryCharge')}}: {{delivery_charge}}</p>
                        </v-form>

                        <v-divider></v-divider>

                        <p class="font-weight-bold">{{$t('words.general.total')}}: {{net_total}}</p>

                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-btn rounded color="blackTheme" class=" mx-auto text-capitalize white--text" @click="confirmOrder()">{{$t('words.general.confirmOrder')}}</v-btn>
                        </v-card-actions>

                        <p class="font-weight-bold">{{$t('words.general.orderNote')}}</p>
                        <p class="text-center">{{$t('words.general.thanksNote')}}</p>
                    </v-card-text>

                </v-card>
            </v-col>
        </v-row>

        <!-- payment method dialog -->
        <v-dialog v-model="paymentDialog" persistent width="400px">
            <v-card>
                <v-card-title>{{$t('words.general.paymentMethod')}}</v-card-title>
                <v-card-text>
                    <v-form v-model="valid" ref="form">
                        <v-radio-group v-model="paymentGroup" :rules="[validRules.required]">
                            <v-radio v-for="item in payment" :key="item.id" :label="getLabel(item)" :value="getValue(item)"></v-radio>
                        </v-radio-group>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn rounded @click="paymentDialog=false" dark>{{$t('words.general.cancel')}}</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn rounded dark @click="buy" :loading="loading">{{$t('words.general.buyNow')}}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- end payment dialog -->
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
        var self = this;
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
            payment: [],
            paymentDialog: false,
            loading:false,
            paymentGroup: '',
            khaltiConfig: {
                "publicKey": "test_public_key_6371fd2fd0134e82a764511e20fd933f",
                "productIdentity": "12345678",
                "productName": "product",
                "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
                "amount": this.net_total,
                "eventHandler": {
                    onSuccess(payload) {
                        console.log('paid')
                        axios.post('api/verifyKhaltiPayment', {
                            'token': payload.token,
                            'amount': payload.amount
                        }).then(res => {
                            self.ordered() //yahabata direct method call hudaina so eso gareko
                        })

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
            cartlist: state => state.product.cartlist,
            auth: state => state.authentication.auth
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
                if(this.carts.length>0){
                     axios.get('api/payment')
                    .then(res => {
                        this.payment = res.data
                        this.paymentDialog = true
                    }).catch(err => console.log(err.response))
                }else{
                    this.$toast.error({
                                    title: "Order",
                                    message: "No items in your cart to order."
                                });
                }
               

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
            this.loading=true
            if (this.$refs.form.validate()) {
                if (this.paymentGroup.gateway_name == 'Khalti') {
                    this.onKhaltiClick()

                } else if (this.paymentGroup.gateway_name == 'Cash On Delivery') {
                    this.ordered()
                } else {
                    console.log('failed')
                }

            }
        },
        onKhaltiClick() {
            let checkout = new KhaltiCheckout(this.khaltiConfig);
            const khaltiCheckout = this.$refs.khaltiCheckout
            checkout.show({
                amount: this.net_total
            });
        },
        ordered() {
            //SAVES ORDER
            axios.post('api/makeOrder', {
                'user_id': this.auth.id,
                'address': this.location,
                'phone': this.contact,
                'delivery_charge': this.delivery_charge,
                'delivery_status': 'Pending',
                'payment_gateway_id': this.paymentGroup.id,
            }).then(res => {
                console.log(res.data.id)
                for (var i = 0; i < this.carts.length; i++) {
                    //SAVE SALE
                    axios.post('api/recordSales', {
                            'order_id': res.data.id,
                            'sales': this.carts[i]
                        }).then(res => {
                            //FORM RESET
                            this.getOrderNotification()
                            this.$refs.form.reset()
                            this.paymentDialog = false
                            this.loading=false
                            this.$router.push({
                                name: 'History'
                            })
                            this.$toast.success({
                                    title: "Order",
                                    message: "You have successfully ordered your item."
                                });
                        })
                        .catch(err => console.log(err.response))
                }
            }).catch(err => console.log(err.response))

            

        },
        getOrderNotification(){
            //SAVES TO FIREBASE FOR NOTIFICATION
            db.collection("notification").add({
                    user_name: this.auth.name,
                    type: 'order',
                    item_num: this.cartlist.length,
                    created_at: new Date(),
                    read_at: null,

                })
                .then(() => {

                })
                .catch(function (error) {
                    console.error("Error adding document: ", error);
                });
        },
        placeChoose() {
            return 'words.general.pleaseChoose'
        },
        placeLocation() {
            return 'words.general.actualLocation'
        },
        placeContact() {
            return 'words.general.yourNumber'
        },
        getLabel(item) {
            return item.gateway_name
        },
        getValue(item) {
            return item
        }
    }
}
</script>
