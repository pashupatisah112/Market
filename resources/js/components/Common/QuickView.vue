<template>
<div>
    <v-dialog v-model="quickViewDialog" width="800" persistent>
        <v-card>
            <v-btn icon @click="closeQuickView" class="float-right">
                <v-icon>mdi-close</v-icon>
            </v-btn>

            <v-container fluid>
                <v-row>
                    <v-col cols="5">
                        <v-img :src="getImage(quickViewItem)"></v-img>
                    </v-col>
                    <v-col cols="6">
                        <v-row>
                            <v-col>
                                <p class="text-h5">{{quickViewItem.title}}</p>
                                <h4>Rs.{{quickViewItem.price}}</h4>
                                <v-form v-model="valid" ref="form">
                                    <div style="width:300px" class="mx-auto">
                                        <p class="float-left mr-7">Size</p>
                                        <v-select v-model="cartSize" :rules="[validRules.required]" :items="quickViewItem.size" item-text="size" item-value="id" item label="Choose Size" dense outlined></v-select>
                                    </div>
                                    <div style="width:300px" class="mx-auto">
                                        <p class="float-left mr-6">Color</p>
                                        <v-select v-model="cartColor" :rules="[validRules.required]" :items="quickViewItem.color" label="Choose Color" item-text="color_name" item-value="id" dense outlined></v-select>
                                    </div>
                                    <div style="width:300px" class="mx-auto">
                                        <p class="float-left mr-5">Count</p>
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

                        <v-row justify="center" class="mt-8">
                            <v-btn @click="addToCart" class="text-capitalize white--text" color="blackTheme" rounded>Add to Cart</v-btn>
                        </v-row>

                        <v-row justify="center" class="mt-5">
                            <v-col cols="6">
                                <v-btn icon color="blackTheme">
                                    <v-icon>mdi-cards-heart</v-icon>
                                </v-btn>
                                <v-btn icon color="blackTheme">
                                    <v-icon>mdi-facebook</v-icon>
                                </v-btn>
                                <v-btn icon color="blackTheme">
                                    <v-icon>mdi-twitter</v-icon>
                                </v-btn>
                                <v-btn icon color="blackTheme">
                                    <v-icon>mdi-instagram</v-icon>
                                </v-btn>
                            </v-col>
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
            cartlistItem:state=>state.product.cartlistItem
        }),
    },
    mounted() {
    },
    methods: {
        ...mapMutations(['closeQuickView','addToCartlist']),
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
            if (this.$refs.form.validate()) {
                if(this.cartlistItem.includes(this.quickViewItem.id)){
                    this.$toast.error({
                        title: "Cart",
                        message: "This product already exist in your cart."
                    });
                }else{
                    axios.post('api/addToCart', {
                        product_id: this.quickViewItem.id,
                        amount: this.count,
                        color: this.cartColor,
                        size: this.cartSize,
                        total: this.count * this.quickViewItem.price
                    }).then(res =>{
                        this.addToCartlist(res.data)
                        this.$toast.success({
                        title: "Cart",
                        message: "Product added to your cart."
                    });
                    } )
                    .catch(err => console.log(err.response))
                }
                
            }
        }
    }
}
</script>
