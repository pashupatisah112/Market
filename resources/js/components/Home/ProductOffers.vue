<template>
<div>
    <v-container fluid>
        <v-row justify="center">
            <h2 class="mt-5">PRODUCTS WITH OFFERS</h2>
        </v-row>
        <v-row class=" mt-5">
            <v-slide-group v-model="model" class="pa-4" center-active show-arrows>
                <v-slide-item v-for="n in 15" :key="n" v-slot="{ toggle }">
                    <v-card max-width="220" class="ma-4" tile flat @click="toggle">
                        <v-hover v-slot="{ hover }">
                            <div style="width:220px;height:250px;overflow: hidden;">
                                <v-img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" width="220" height="250" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                    <v-slide-y-reverse-transition hide-on-leave>
                                        <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                            <v-btn rounded color="white" class="text-capitalize" small>Quick View</v-btn>
                                        </div>
                                    </v-slide-y-reverse-transition>
                                </v-img>

                            </div>

                        </v-hover>
                        <v-card-actions class="pa-0">
                            <v-card-subtitle class="pa-0">
                                product name
                            </v-card-subtitle>

                            <v-spacer></v-spacer>

                            <v-btn icon>
                                <v-icon>mdi-cards-heart</v-icon>
                            </v-btn>
                        </v-card-actions>
                        <v-card-title class="pa-0">
                            price
                        </v-card-title>

                    </v-card>
                </v-slide-item>
            </v-slide-group>
        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            model: null,
            chips: [{
                    title: 'Coat'
                },
                {
                    title: 'Sarees'
                },
                {
                    title: 'Jeans'
                },
                {
                    title: 'Shirt'
                },
                {
                    title: 'Hoodies'
                },
                {
                    title: 'Lehenga'
                },
                {
                    title: 'Jumpsuit'
                },
                {
                    title: 'Jacket'
                },
            ]
        }
    },
    methods: {
        productHover() {

        }
    }
}
</script>
