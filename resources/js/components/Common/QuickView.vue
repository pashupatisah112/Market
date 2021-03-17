<template>
<div>
    <v-dialog v-model="quickViewDialog" max-width="600" persistent>
        <v-card>
            <v-btn icon @click="closeQuickView" class="float-right">
                <v-icon>mdi-close</v-icon>
            </v-btn>

            <v-container fluid>
                <v-row>
                    <v-col cols="12" lg="5" md="5" sm="5" align="center">
                        <v-img :src="getImage(quickViewItem)" max-width="200" max-height="300"></v-img>
                    </v-col>
                    <v-col cols="12" lg="7" md="7" sm="7">
                        <v-row justify="center">
                            <v-col cols="12" align="center">
                                <p class="text-h5 text-left">{{quickViewItem.title}}</p>
                                <h4 class="text-left mb-2">Rs.{{quickViewItem.price}}</h4>
                                <v-form v-model="valid" ref="form" >
                                    <div class="mx-auto" v-if="quickViewItem.size.length>0">
                                        <p class="float-left mr-7">{{$t('words.detail.size')}}</p>
                                        <v-select v-model="cartSize" :rules="[validRules.required]" :items="quickViewItem.size" item-text="size" item-value="id" item :label="$t(placeSize())" dense outlined></v-select>
                                    </div>
                                    <div class="mx-auto" v-if="quickViewItem.color.length>0">
                                        <p class="float-left mr-6">{{$t('words.detail.color')}}</p>
                                        <v-select v-model="cartColor" :rules="[validRules.required]" :items="quickViewItem.color" :label="$t(placeSize())" item-text="color_name" item-value="id" dense outlined></v-select>
                                    </div>
                                    <div class="mx-auto">
                                        <p class="float-left mr-5">{{$t('words.detail.count')}}</p>
                                        <v-btn-toggle>
                                            <v-btn @click="countMinus" icon>
                                                <v-icon>mdi-minus</v-icon>
                                            </v-btn>
                                            <v-btn class="text--black">
                                                {{count}}
                                            </v-btn>
                                            <v-btn icon @click="countPlus">
                                                <v-icon>mdi-plus</v-icon>
                                            </v-btn>
                                        </v-btn-toggle>
                                    </div>
                                </v-form>
                            </v-col>

                        </v-row>

                        <v-row justify="center" class="my-2">
                            <v-btn @click="addToCart" class="text-capitalize white--text" color="blackTheme" rounded>{{$t('words.detail.addToCart')}}</v-btn>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</div>
</template>

<script>
import {
    mapState,
    mapMutations
} from 'vuex';
import {
    mapFields
} from 'vuex-map-fields';
export default {
    data() {
        return {
            cartColor: '',
            cartSize: '',
            count: 1,
            valid: true
        }
    },
    computed: {
        ...mapState({
            quickViewDialog: state => state.product.quickViewDialog,
            quickViewItem: state => state.product.quickViewItem,
            validRules: state => state.validation.validRules,
            cartlistItem: state => state.product.cartlistItem,
            token: state => state.authentication.token
        }),
    },
    
    methods: {
        ...mapMutations(['closeQuickView', 'addToCartlist','setLoginDialog']),
        countPlus() {
            this.count = this.count + 1
        },
        countMinus() {
            if (this.count != 1) {
                this.count = this.count - 1
            }

        },
        getImage(quickViewItem) {
            return quickViewItem.image
        },
        addToCart() {
            if (this.token) {
                if (this.$refs.form.validate()) {
                    if (this.cartlistItem.includes(this.quickViewItem.id)) {
                        this.$toast.error({
                            title: "Cart",
                            message: "This product already exist in your cart."
                        });
                    } else {
                        axios.post('api/addToCart', {
                                product_id: this.quickViewItem.id,
                                amount: this.count,
                                color: this.cartColor,
                                size: this.cartSize,
                                total: this.count * this.quickViewItem.price
                            }).then(res => {
                                this.addToCartlist(res.data)
                                this.closeQuickView()
                                this.$toast.success({
                                    title: "Cart",
                                    message: "Product added to your cart."
                                });
                            })
                            .catch(err => console.log(err.response))
                    }

                }
            }
            else{
                this.setLoginDialog()
            }

        },
         placeColor(){
            return 'words.detail.chooseColor'
        },
        placeSize(){
            return 'words.detail.chooseSize'
        }
    }
}
</script>
