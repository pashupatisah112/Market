<template>
<div>
    <v-container fluid>
        <v-row>
            <v-col cols="12" lg="8" md="8">
                <v-card flat>
                    <v-container fluid>
                        <v-row class="px-10">
                            <v-col cols="1">
                                <div style="width:50px; height:75px;margin-bottom:10px">
                                    <v-img src="../images/sample.png"></v-img>
                                </div>
                                <div style="width:50px; height:75px">
                                    <v-img src="../images/sample2.png"></v-img>
                                </div>
                                <div style="width:50px; height:75px">
                                    <v-img src="../images/sample3.jpg"></v-img>
                                </div>
                                <div style="width:50px; height:75px">
                                    <v-img src="../images/sample4.jpg"></v-img>
                                </div>
                                <div style="width:50px; height:75px">
                                    <v-img src="../images/sample5.jpg"></v-img>
                                </div>
                            </v-col>
                            <v-col cols="5">
                                <v-img src="../images/sample.png"></v-img>
                            </v-col>
                            <v-col cols="6">
                                <v-row>
                                    <v-col>
                                        <p class="text-h5">Name of the product</p>
                                        <h4>Rs.1800</h4>
                                        <p class="body-2">short description</p>
                                        <div style="width:300px" class="mx-auto">
                                            <p class="float-left mr-7">Size</p>
                                            <v-select :items="items" label="Choose Size" dense outlined></v-select>
                                        </div>
                                        <div style="width:300px" class="mx-auto">
                                            <p class="float-left mr-6">Color</p>
                                            <v-select :items="items" label="Choose Color" dense outlined></v-select>
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
                                    </v-col>

                                </v-row>

                                <v-row justify="center" class="mt-8">
                                    <v-btn class="text-capitalize white--text mx-2" color="blackTheme" rounded>Add to Cart</v-btn>
                                    <v-btn class="text-capitalize white--text mx-2" color="blackTheme" rounded>Buy Now</v-btn>

                                </v-row>
                                <v-row>
                                    <p class="caption">Rate it: </p>
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
                                <v-divider></v-divider>

                            </v-col>
                        </v-row>
                        <v-row class="px-10">
                            <v-card flat>
                                <v-tabs v-model="tab" background-color="transparent" color="basil" grow>
                                    <v-tab v-for="item in details" :key="item">
                                        {{ item }}
                                    </v-tab>
                                </v-tabs>

                                <v-tabs-items v-model="tab">
                                    <v-tab-item v-for="item in details" :key="item">
                                        <v-card color="basil" flat>
                                            <v-card-text>{{ text }}</v-card-text>
                                        </v-card>
                                    </v-tab-item>
                                </v-tabs-items>
                            </v-card>
                        </v-row>
                    </v-container>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
import {
    mapState
} from 'vuex';
import {
    mapFields
} from 'vuex-map-fields';
export default {
    data() {
        return {
            count: 1,
            items: ['Blue', 'Green', 'Black', 'Yellow'],
            tab: null,
            details: [
                'More Details', 'Questions and Comments', 'Deliver Options', 'Guarantees and Refunds',
            ],
            text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        }
    },
    computed: {
        ...mapState(['quickViewDialog']),
        ...mapFields(['quickViewDialog'])
    },
    methods: {
        closeQuickView() {
            this.quickViewDialog = false
        },
        countPlus() {
            this.count = this.count + 1
        },
        countMinus() {
            if (this.count != 1) {
                this.count = this.count - 1
            }

        }
    }
}
</script>
