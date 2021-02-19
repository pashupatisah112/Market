<template>
<div>
    <v-container fluid>
        <v-row style="background-color:rgba(0, 0, 0, 0.87)" justify="center">

            <v-btn text dark small class="text-lowercase mx-sm-auto">
                <v-icon dense size="18" color="white" class="mr-1">mdi-email</v-icon>
                info@esmartorder.com
            </v-btn>

            <v-divider vertical class="my-3 mx-2" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-btn text dark small class="text-lowercase mx-sm-auto">
                <v-icon dense size="18" color="white" class="mr-1">mdi-cellphone</v-icon>
                9815790619
            </v-btn>

            <v-spacer></v-spacer>

            <div class="hidden-sm-and-down">
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
                    <v-btn dark v-bind="attrs" v-on="on" small text depressed color="transparent" class="text-capitalize mx-sm-auto">
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

            <account class="mx-sm-auto"></account>

        </v-row>

        <v-row class="mt-3">
            <v-toolbar extended dense short max-height="50" elevation="0" class="mb-1">
                <div class="hidden-lg-and-up mr-n10">
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn icon v-bind="attrs" v-on="on" large>
                                <v-icon> mdi-format-list-bulleted-square</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item>
                                <v-btn text class="text-capitalize" @click="goHome">
                                    {{ $t('words.header.home') }}
                                </v-btn>
                            </v-list-item>
                            <v-list-item>
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
                            </v-list-item>
                            <v-list-item>
                                <v-btn text class="text-capitalize" to="/top-sellers">
                                    Top selling
                                </v-btn>
                            </v-list-item>
                            <v-list-item>
                                <v-btn text class="text-capitalize" to="/collections">
                                    {{ $t('words.header.collections') }}
                                </v-btn>
                            </v-list-item>
                            <v-list-item>
                                <v-btn text class="text-capitalize" to="/offers">
                                    Offers
                                </v-btn>
                            </v-list-item>
                            <v-list-item>
                                <v-btn text class="text-capitalize" to="/sale">
                                    Sale
                                </v-btn>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>

                <v-img src="../images/logo.png" max-width="200" height="50"></v-img>

                <div class="hidden-md-and-down">
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
                </div>

                <v-spacer></v-spacer>
                <div>
                    <v-expand-x-transition>
                        <v-text-field rounded filled dense placeholder="Search items here..." v-show="search" v-model="searchItem" class="mt-7 mr-2"></v-text-field>
                    </v-expand-x-transition>
                </div>
                <div class="hidden-md-and-down">
                    <v-btn icon @click="searchOptions" small class="mr-2">
                        <v-icon>mdi-account-search</v-icon>
                    </v-btn>
                </div>

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
        <v-row class="hidden-lg-and-up px-5">
            <v-expand-x-transition>
                <v-text-field rounded filled dense placeholder="Search items here..." v-model="searchItem">

                    <template slot="append">
                        <v-btn rounded small class="white--text text-capitalize mr-n4 mt-n1" color="blackTheme">Search</v-btn>
                    </template>
                </v-text-field>
            </v-expand-x-transition>
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
            token: state => state.authentication.token,
            loginDialog: state => state.authentication.loginDialog,
            cartlist: state => state.product.cartlist,
            wishlist: state => state.product.wishlist,
            wishListItem: state => state.product.wishListItem,
            quickViewDialog: state => state.product.quickViewDialog,
            token: state => state.authentication.token
        }),
        ...mapFields(['loginDialog'])
    },
    created() {
        this.checkUser()
        this.getCategories()
        if (this.token) {
            this.getWishlistItem()
            this.getCartListItem()
        }

    },
    methods: {
        ...mapMutations(['addWishlistItem', 'getCartListItem', 'setToken','setSearchItem']),
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
                    this.setSearchItem(this.searchItem)
                    this.$router.push({
                        name:'Search',
                         params: { search: this.searchItem }
                    })
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
