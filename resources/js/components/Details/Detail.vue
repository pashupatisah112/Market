<template>
<div>
    <v-container fluid>
        <v-row class="px-10">
            <v-col cols="1" align="center">
                <div style="width:60px; height:auto;margin-bottom:10px" v-for="item in product.photo" :key="item.id">
                    <v-img :src="getImage(item)" @click="zoomImage(item)"></v-img>
                </div>
            </v-col>
            <v-col cols="5">
                <div v-if="!imageView">
                    <v-img :src="getPrimaryImage(product)"></v-img>
                </div>

                <div v-if="imageView">
                    <v-img :src="showImage(imageData)">
                        <v-btn fab light x-small class="ma-1" style="position:absolute;right:0;" @click="cancelZoom">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-img>
                </div>
            </v-col>
            <v-col cols="6">
                <v-row>
                    <v-col>
                        <p class="text-h5">{{product.title}}</p>
                        <h4>{{$t('words.general.rs')}}. {{product.price}}</h4>
                        <p class="body-2">short description</p>
                        <v-form v-model="valid" ref="form">
                            <div style="width:300px" class="mx-auto" v-if="product.size.length>0">
                                <p class="float-left mr-7">{{$t('words.detail.size')}}</p>
                                <v-select v-model="cartSize" :rules="[validRules.required]" :items="product.size" item-text="size" item-value="id" :label="$t(placeSize())" dense outlined></v-select>
                            </div>
                            <div style="width:300px" class="mx-auto" v-if="product.color.length>0">
                                <p class="float-left mr-6">{{$t('words.detail.color')}}</p>
                                <v-select v-model="cartColor" :rules="[validRules.required]" :items="product.color" :label="$t(placeColor())" item-text="color_name" item-value="id" dense outlined></v-select>
                            </div>
                            <div style="width:300px" class="mx-auto">
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

                <v-row justify="center" class="mt-8">
                    <v-btn class="text-capitalize white--text mx-2" color="blackTheme" rounded @click="addToCart">{{$t('words.detail.addToCart')}}</v-btn>
                    <v-btn class="text-capitalize white--text mx-2" color="blackTheme" rounded>{{$t('words.detail.buyNow')}}</v-btn>

                </v-row>

            </v-col>
        </v-row>
        <v-row class="px-10">
            <v-card flat>
                <v-card-title>{{$t('words.detail.description')}}</v-card-title>
                <v-card-text v-html="product.description">

                </v-card-text>
            </v-card>
        </v-row>

    </v-container>

</div>
</template>

<script>
import {
    mapState, mapMutations
} from 'vuex';

export default {
    data() {
        return {
            product: {color:[],size:[]},
            valid:true,
            count: 1,
            imageView: false,
            imageData: null,
            cartSize: '',
            cartColor: '',

        }
    },
    computed: {
        product_code() {
            return this.$route.params.code
        },
        product_title() {
            return this.$route.params.title
        },
        ...mapState({
            validRules: state => state.validation.validRules,
            cartlistItem:state=>state.product.cartlistItem

        })
    },
    mounted() {
        this.getProductDetails()
    },
    methods: {
        ...mapMutations(['addToCartlist']),
        getProductDetails() {
            axios.post('api/getProductDetails', {
                    code: this.product_code
                }).then(res => {
                    this.product = res.data
                })
                .catch(err => console.log(err.response))
        },
        getImage(item) {
            return item.image
        },
        getPrimaryImage(product) {
            return product.image
        },
        showImage(imageData) {
            return imageData.image
        },
        countPlus() {
            this.count = this.count + 1
        },
        countMinus() {
            if (this.count != 1) {
                this.count = this.count - 1
            }

        },
        zoomImage(item) {
            this.imageData = item
            this.imageView = true
        },
        cancelZoom() {
            this.imageView = false
            this.imageData = null
        },
         addToCart(product) {
            if (this.$refs.form.validate()) {
                if(this.cartlistItem.includes(this.product.id)){
                    this.$toast.error({
                        title: "Cart",
                        message: "This product already exist in your cart."
                    });
                }else{
                    axios.post('api/addToCart', {
                        product_id: this.product.id,
                        amount: this.count,
                        color: this.cartColor,
                        size: this.cartSize,
                        total: this.count * this.product.price
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
