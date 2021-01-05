<template>
<div>
    <v-container>
        <v-row>
            <v-col cols="8">
                <v-simple-table class="border">
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Product
                                </th>
                                <th class="text-left">
                                    Price
                                </th>
                                <th class="text-left">
                                    Quantity
                                </th>
                                <th class="text-left">
                                    Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in items" :key="item.title">
                                <td>
                                    <v-list two-line dense>
                                        <v-list-item>
                                            <v-list-item-avatar tile size="60">
                                                <v-img :alt="`${item.title} avatar`" :src="item.avatar"></v-img>
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title v-text="item.title"></v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                </td>
                                <td>Rs.800</td>
                                <td>
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
                                </td>
                                <td>800</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-col>
            <v-col cols="4">
                <v-card outlined flat>
                    <v-card-title>
                        CART TOTALS
                    </v-card-title>

                    <v-card-text>
                        Subtotal: Rs.5000
                    </v-card-text>

                    <v-divider class="mx-5"></v-divider>
                    
                    <v-card-text>
                        Shipping: 
                    </v-card-text>

                    <v-divider class="mx-5"></v-divider>

                    Total: Rs.8000

                    <v-btn rounded color="blackTheme" class="text-capitalize white--text mt-12">Proceed to CheckOut</v-btn>
                    
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            count: 1,
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
