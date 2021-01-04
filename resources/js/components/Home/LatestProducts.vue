<template>
<div>
    <v-container fluid>
        <v-row justify="center">
            <h2 class="mt-5">LATEST PRODUCTS</h2>
        </v-row>
        <v-row class=" mt-5">
            <v-col cols="12" lg="3" md="3" v-for="i in 4" :key="i">
                <v-card max-width="220" class="mx-auto" tile flat>
                    <v-hover v-slot="{ hover }">
                        <div style="width:220px;height:250px;overflow: hidden;">
                            <v-img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" width="220" height="250" style="transition: transform .4s;" :class="{ 'on-hover': hover }">
                                <v-slide-y-reverse-transition hide-on-leave>
                                    <div v-if="hover" class="d-flex transition-fast-in-fast-out v-card--reveal" style="height: 30%;">
                                        <v-btn rounded color="white" class="text-capitalize" small @click="quickView">Quick View</v-btn>
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
            </v-col>

        </v-row>
    </v-container>
</div>
</template>

<script>
import { mapState } from 'vuex'
import {mapFields} from 'vuex-map-fields';
export default {
    data() {
        return {

        }
    },
    computed:{
        ...mapState(['quickViewDialog']),
        ...mapFields(['quickViewDialog'])
    },
    methods: {
        quickView(){
            this.quickViewDialog=true
        }
    }
}
</script>
