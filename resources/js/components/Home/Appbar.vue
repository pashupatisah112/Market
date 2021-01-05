<template>
<div>
    <v-container fluid>
        <v-row class="px-10" style="background-color:rgba(0, 0, 0, 0.87)">
            <v-icon dense class="pr-1" color="white">mdi-email</v-icon>
            <p class="caption mt-4 white--text">info@onlinemarket.com</p>

            <v-divider vertical class="my-3 mx-2" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-icon dense color="white">mdi-cellphone</v-icon>
            <p class="caption mt-4 white--text">9815790619</p>

            <v-spacer></v-spacer>

            <v-btn icon small class="mt-3">
                <v-icon dense size="18" color="white">mdi-facebook</v-icon>
            </v-btn>
            <v-btn icon small class="mt-3">
                <v-icon dense size="18" color="white">mdi-twitter</v-icon>
            </v-btn>
            <v-btn icon small class="mt-3">
                <v-icon dense size="18" color="white">mdi-linkedin</v-icon>
            </v-btn>
            <v-btn icon small class="mt-3">
                <v-icon dense size="18" color="white">mdi-pinterest</v-icon>
            </v-btn>

            <v-divider vertical class="my-3 mx-2" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn dark v-bind="attrs" v-on="on" small text depressed color="transparent" class="mt-3 text-capitalize">
                        <v-icon>mdi-flag-checkered</v-icon>
                        English
                    </v-btn>
                </template>
                <v-list dense elevation="0">
                    <v-list-item v-for="(item, index) in items" :key="index" dense>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-divider vertical class="my-3 mx-2" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-btn small text depressed color="transparent" class="mt-3 text-capitalize white--text">
                <v-icon color="white">mdi-account</v-icon>
                Login
            </v-btn>
        </v-row>

        <v-divider class="mx-0 mt-3"></v-divider>

        <v-toolbar extended dense short max-height="50" elevation="0">
            <v-toolbar-title class="mr-12">
                <span class="heading-3 font-weight-bold">COZA</span> Store
            </v-toolbar-title>

            <v-btn text class="text-capitalize">
                Home
            </v-btn>

            <v-menu open-on-hover bottom offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn text v-bind="attrs" v-on="on" class="text-capitalize">
                        Categories
                    </v-btn>
                </template>
                <v-card>
                    <v-container fluid>
                        <v-row>
                            <v-col>
                                <p class="font-weight-bold">Men's Fashion</p>
                                <v-btn text small class="text-capitalize" @click="goToList">Jackets</v-btn><br>
                                <v-btn text small class="text-capitalize">Hoodies</v-btn><br>
                                <v-btn text small class="text-capitalize">Sweater</v-btn><br>
                                <v-btn text small class="text-capitalize">Trousers</v-btn><br>
                                <v-btn text small class="text-capitalize">Accessories</v-btn>
                            </v-col>
                            <v-col>
                                <p class="font-weight-bold">Women's Fashion</p>
                                <v-btn text small class="text-capitalize">Jackets</v-btn><br>
                                <v-btn text small class="text-capitalize">Sarees</v-btn><br>
                                <v-btn text small class="text-capitalize">Kurta</v-btn><br>
                                <v-btn text small class="text-capitalize">Lehenga</v-btn><br>
                                <v-btn text small class="text-capitalize">Jumsuit</v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card>
            </v-menu>

            <v-btn text class="text-capitalize">
                Collections
            </v-btn>

            <v-btn text class="text-capitalize">
                About
            </v-btn>

            <v-btn text class="text-capitalize">
                Contact
            </v-btn>

            <v-spacer></v-spacer>
            <v-expand-x-transition>
                <v-text-field rounded filled dense placeholder="Search items here..." v-show="search" v-model="searchItem" class="mt-7 mr-2"></v-text-field>
            </v-expand-x-transition>

            <v-btn icon @click="searchOptions">
                <v-icon>mdi-account-search</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-cards-heart</v-icon>
            </v-btn>

            <v-menu bottom open-on-hover offset-y transition="expand-transition">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>mdi-cart</v-icon>
                    </v-btn>
                </template>
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
                                            <v-list-subtitle>1 x Rs.500</v-list-subtitle>
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
            </v-menu>
        </v-toolbar>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            search: false,
            searchItem: null,
            categories: [{
                title: "Men's Fashion"
            }, {
                title: "Women's Fashion"
            }],
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
    methods: {
        goToList() {
            this.$router.push({
                name: 'Category'
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
        viewCart(){
            this.$router.push({name:'Cart'})
        }
    }
}
</script>
