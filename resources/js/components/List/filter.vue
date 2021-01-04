<template>
<div>
    <v-container fluid>
        <v-row class="px-10">
            <p class="font-weight-bold text-decoration-underline">Men's Fashion</p>
            <!-- trending wala haru fetch gar jati aatxa in one line -->
            <p class="mx-3">Shirt</p>
            <p class="mx-3">Pant</p>
            <p class="mx-3">Jeans</p>
            <p class="mx-3">Coat</p>
            <p class="mx-3">Hoodies</p>

            <v-spacer></v-spacer>

            <v-btn outlined rounded @click="expand=!expand">
                <v-icon>mdi-filter-variant</v-icon>
                Filter
            </v-btn>

            <v-expand-transition>
                <v-card class="w-100" v-show="expand" color="background" flat>
                    <v-container fluid>
                        <v-row>
                            <v-col cols="12" lg="3" md="6">
                                <p class="body-1 font-weight-bold">Sort By</p>
                                <v-btn text class="body-2">Default</v-btn>
                                <v-btn text class="body-2">Popularity</v-btn>
                                <v-btn text class="body-2">Average Rating</v-btn>
                                <v-btn text class="body-2">Newest</v-btn>
                                <v-btn text class="body-2">Price: Low to High</v-btn>
                                <v-btn text class="body-2">Price: High to Low</v-btn>
                            </v-col>
                            <v-col cols="12" lg="3" md="6">
                                <p class="body-1 font-weight-bold">Price</p>
                                <v-btn text class="body-2">All</v-btn>
                                <v-btn text class="body-2">Rs.0 - Rs. 1000</v-btn>
                                <v-btn text class="body-2">Rs.1000 - Rs. 2000</v-btn>
                                <v-btn text class="body-2">Rs.2000 - Rs. 3000</v-btn>
                                <v-btn text class="body-2">Rs.3000 - Rs. 5000</v-btn>
                                <v-btn text class="body-2">Rs.5000+</v-btn>
                            </v-col>
                            <v-col cols="12" lg="3" md="6">
                                <p class="body-1 font-weight-bold">Color</p>
                                <v-btn class="body-2">
                                    <v-icon color="black">mdi-checkbox-blank-circle</v-icon>Black
                                </v-btn>
                                <v-btn class="body-2">
                                    <v-icon color="black">mdi-checkbox-blank-circle</v-icon>Black
                                </v-btn>
                                <v-btn class="body-2">
                                    <v-icon color="black">mdi-checkbox-blank-circle</v-icon>Black
                                </v-btn>
                                <v-btn class="body-2">
                                    <v-icon color="black">mdi-checkbox-blank-circle</v-icon>Black
                                </v-btn>
                                <v-btn class="body-2">
                                    <v-icon color="black">mdi-checkbox-blank-circle</v-icon>Black
                                </v-btn>
                                <v-btn class="body-2">
                                    <v-icon color="black">mdi-checkbox-blank-circle</v-icon>Black
                                </v-btn>
                            </v-col>
                            <v-col cols="12" lg="3" md="6">
                                <v-badge color="transparent" outlined>Fashion</v-badge>
                                <v-badge color="transparent" outlined>Lifestyle</v-badge>
                                <v-badge color="transparent" outlined>Denim</v-badge>
                                <v-badge color="transparent" outlined>Stretstyle</v-badge>
                                <v-badge color="transparent" outlined>Crafts</v-badge>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card>
            </v-expand-transition>

        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            expand: false
        }
    }
}
</script>
