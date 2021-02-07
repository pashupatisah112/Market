<template>
<div>
    <v-container fluid>
        <v-row class="px-5" style="background-color:rgba(0, 0, 0, 0.87)">

            <v-icon dense class="pr-1" color="white">mdi-email</v-icon>
            <p class="caption mt-4 white--text">info@esmartorder.com</p>

            <v-divider vertical class="my-3 mx-2" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-icon dense color="white">mdi-cellphone</v-icon>
            <p class="caption mt-4 white--text">9815790619</p>

            <v-spacer></v-spacer>

            <div class="hidden-sm-and-down mt-3">
                <v-btn icon small>
                    <v-icon dense size="18" color="white">mdi-facebook</v-icon>
                </v-btn>
                <v-btn icon small>
                    <v-icon dense size="18" color="white">mdi-twitter</v-icon>
                </v-btn>
                <v-btn icon small>
                    <v-icon dense size="18" color="white">mdi-linkedin</v-icon>
                </v-btn>
                <v-btn icon small>
                    <v-icon dense size="18" color="white">mdi-pinterest</v-icon>
                </v-btn>
            </div>

            <v-divider vertical class="my-3 mx-2 hidden-sm-and-down" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn dark v-bind="attrs" v-on="on" small text depressed color="transparent" class="mt-3 text-capitalize mx-auto">
                        <v-icon>mdi-flag-checkered</v-icon>
                        {{ $t('words.header.lang') }}

                    </v-btn>
                </template>
                <v-list dense elevation="0">
                    <v-list-item v-for="(item, index) in lang" :key="index" dense @click="setLocale(item.lang)">
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-divider vertical class="my-3 mx-2" style="border-color:rgba(255,255,255,0.2)"></v-divider>
            
            <account></account>
           
        </v-row>

        <v-row>
            <v-toolbar extended dense short max-height="50" elevation="0" class="mb-1">
                <v-toolbar-title class="mr-12">
                    <span class="heading-3 font-weight-bold">COZA</span> Store
                </v-toolbar-title>

                <v-btn text class="text-capitalize" @click="goHome">
                    {{ $t('words.header.home') }}
                </v-btn>

                <v-menu open-on-hover bottom offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn text v-bind="attrs" v-on="on" class="text-capitalize">
                            {{ $t('words.header.categories') }}
                        </v-btn>
                    </template>
                    <v-card max-width="1200">
                        <v-container fluid>
                            <v-row>
                                <v-col co v-for="item in categories" :key="item.id">
                                    <p class="font-weight-bold">{{item.category_name}}</p>
                                    <v-btn text small class="text-capitalize" v-for="sub in item.subcategory" :key="sub.id" @click="goToList(item,sub)">{{sub.subCategory_name}}</v-btn><br>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-menu>
                
                 <v-btn text class="text-capitalize" to="/top-sellers">
                    Top selling
                </v-btn>

                <v-btn text class="text-capitalize" to="/collections">
                    {{ $t('words.header.collections') }}
                </v-btn>

                <v-btn text class="text-capitalize" to="/offers">
                    Offers
                </v-btn>

                <v-btn text class="text-capitalize" to="/sale">
                    Sale
                </v-btn>

                <v-spacer></v-spacer>
                <v-expand-x-transition>
                    <v-text-field rounded filled dense placeholder="Search items here..." v-show="search" v-model="searchItem" class="mt-7 mr-2"></v-text-field>
                </v-expand-x-transition>

                <v-btn icon @click="searchOptions" small class="mr-2">
                    <v-icon>mdi-account-search</v-icon>
                </v-btn>

                <!--wishlist component-->
                <v-menu bottom open-on-hover offset-y transition="expand-y-transition" v-if="token">
                    <template v-slot:activator="{ on, attrs }">
                        <v-badge color="green" :value="wishlist.length" :content="wishlist.length" overlap>
                            <v-btn icon v-bind="attrs" v-on="on" small>
                                <v-icon>mdi-cards-heart</v-icon>
                            </v-btn>
                        </v-badge>
                    </template>
                    <wishlist></wishlist>
                </v-menu>
                <!--end wishlist component-->

                <!--cart component-->
                <v-menu bottom open-on-hover offset-y transition="expand-y-transition" v-if="token">
                    <template v-slot:activator="{ on, attrs }">
                         <v-badge color="green" :value="cartlist.length" :content="cartlist.length" overlap>

                        <v-btn icon v-bind="attrs" v-on="on" small class="ml-3">
                            <v-icon>mdi-cart</v-icon>
                        </v-btn>
                        </v-badge>
                    </template>
                    <cart></cart>
                </v-menu>
                <!--end cart component-->
            </v-toolbar>
        </v-row>

        <!--login component-->
        <auth></auth>
        <!--end login component-->

        <quickView></quickView>
    </v-container>
</div>
</template>

<script>
import {
    mapState,
    mapActions,
    mapMutations
} from 'vuex';
import {
    mapFields
} from 'vuex-map-fields';

import Wishlist from './Wishlist';
import QuickView from '../Common/QuickView';
import Cart from './Cart';
import Account from '../Account/Account';
import Auth from '../Account/Auth';
export default {
    components: {
        Wishlist,
        Cart,
        QuickView,
        Account,
        Auth
    },
    data() {
        return {
            wishCount: 0,
            search: false,
            searchItem: null,
            selectedLang: '',
            categories: [],
            
            menus: [{
                    title: 'Home',
                    link: ''
                },
                {
                    title: 'Categories',
                    link: ''
                },
                {
                    title: 'Collections',
                    link: ''
                },
                {
                    title: 'About Us',
                    link: ''
                },
                {
                    title: 'Contact',
                    link: ''
                },

            ],

            lang: [{
                    title: 'English',
                    lang: 'en'
                },
                {
                    title: 'Nepali',
                    lang: 'nep'
                },
            ],
        }
    },
    computed: {
        ...mapState({
            validRules: state => state.validation.validRules,
            token:state=>state.authentication.token,
            loginDialog: state => state.authentication.loginDialog,
            cartlist: state => state.product.cartlist,
            wishlist: state => state.product.wishlist,
            wishListItem: state => state.product.wishListItem,
            quickViewDialog: state => state.product.quickViewDialog
        }),
        ...mapFields(['loginDialog'])
    },
    created() {
         this.checkUser()
        this.getCategories()
        // this.getWishlistItem()
        // this.getCartListItem()
    },
    methods: {
        ...mapMutations(['addWishlistItem', 'getCartListItem','setToken']),
        getWishlistItem() {
            axios.get('api/getWishlistItem')
                .then(res => {
                    this.wishCount = res.data.length
                    this.addWishlistItem(res.data)
                })
                .catch(err => console.log(err.response))
        },

        
        goToList(item, sub) {
            this.$router.push({
                name: 'Category',
                params: {
                    category: item.category_name,
                    subCategory: sub.subCategory_name
                }
            });
        },
        searchOptions() {
            if (this.search == false) {
                this.search = true
            } else {
                if (this.searchItem == null) {
                    this.search = false
                } else {
                    console.log('search item')
                }

            }
        },

        setLocale(language) {
            this.$store.dispatch('changeLocale', language)
                .then(() => {
                    this.$i18n.locale = language;
                }).catch((error => {}));
        },
       
        goHome() {
            this.$router.push({
                name: 'Home',
            })
        },
        getCategories() {
            axios.get('api/getCategories')
                .then(res => {
                    this.categories = res.data
                })
                .catch(err => console.log(err.response))
        },
        checkUser() {
            if (localStorage.getItem('token')) {
                this.setToken()
            }
        },
    }
}
</script>
