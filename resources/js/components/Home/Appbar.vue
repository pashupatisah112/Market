<template>
<div>
    <v-container fluid>
        <v-row class="px-10" style="background-color:#333333">
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

                <v-btn text class="text-capitalize">
                    Categories
                </v-btn>

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

                 <v-btn icon>
                    <v-icon>mdi-account-search</v-icon>
                </v-btn>

                <v-btn icon>
                    <v-icon>mdi-cards-heart</v-icon>
                </v-btn>

                <v-btn icon>
                    <v-icon>mdi-cart</v-icon>
                </v-btn>

            </v-toolbar>           
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            items: [{
                title: 'English'
            }, {
                title: 'Nepali'
            }],
            menus:[
                {title:'Home',link:''},
                {title:'Categories',link:''},
                {title:'Collections',link:''},
                {title:'About Us',link:''},
                {title:'Contact',link:''},

            ]
        }
    }
}
</script>
