<template>
<div>
    <v-app>
        <v-container fluid style="width:600px">
            <v-row justify="center">
                <v-col cols="8">
                    <v-row>
                        <p class="text-h4">INVOICE</p>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <P class="font-weight-bold">Invoice number</P>
                            <P class="mt-n4">{{invoiceOrder.order_id}}</P>
                        </v-col>
                        <v-col cols="6">
                            <P class="font-weight-bold">Date of issue</P>
                            <P class="mt-n4">{{new Date().toDateString()}}</P>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <P class="font-weight-bold">Billed to</P>
                            <P class="mt-n4">{{invoiceOrder.user}}</P>
                            <P class="mt-n4">{{invoiceOrder.address}}</P>
                            <p class="mt-n4">{{invoiceOrder.phone}}</p>
                        </v-col>
                        <v-col cols="6">
                            <P class="font-weight-bold">Esmartorder</P>
                            <P class="mt-n4">Kadaghari-9,KTM</P>
                            <P class="mt-n4">+977-9815790619</P>
                            <p class="mt-n4">info@esmartorder.com</p>
                            <p class="mt-n4">www.esmartorder.com</p>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="4">
                    <v-img src="../images/logo.png" max-width="200" height="50"></v-img>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-simple-table dense>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Product
                                </th>
                                <th class="text-left">
                                    Color
                                </th>
                                <th class="text-left">
                                    Size
                                </th>
                                <th class="text-left">
                                    Price
                                </th>
                                <th class="text-left">
                                    Quantity
                                </th>
                                <th class="text-left">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in invoiceProduct" :key="item.id">
                                <td>{{item.product.title}}</td>
                                <td>{{ item.color.color_name }}</td>
                                <td>{{ item.size.size }}</td>
                                <td>{{ item.product.price }}</td>
                                <td>
                                    {{ item.quantity }}
                                </td>
                                <td>
                                    {{ item.quantity * item.product.price }}
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>

            </v-row>

            <v-row justify="end">
                <v-col cols="4">
                    <p><span class="font-weight-bold">Subtotal: {{invoiceTotal}}</span></p>
                    <p class="mt-n4"><span class="font-weight-bold">Discount: {{totalDiscount}}</span></p>
                    <p class="mt-n4"><span class="font-weight-bold">Delivery charge:{{invoiceOrder.delivery_charge}}</span></p>
                    <v-btn tile dark class="text-capitalize">
                        Invoice Total: <span class="text-h6">{{invoiceTotal + totalDiscount + invoiceOrder.delivery_charge}}</span>
                    </v-btn>
                </v-col>

            </v-row>

        </v-container>
    </v-app>

</div>
</template>

<script>
import {
    mapState
} from 'vuex';
export default {
    data() {
        return {
            totalDiscount: 0,
        }
    },
    computed: {
        ...mapState({
            invoiceOrder: state => state.product.invoiceOrder,
            invoiceProduct: state => state.product.invoiceProduct,
            invoiceTotal: state => state.product.invoiceTotal
        })
    },
    mounted() {
        window.print()
    },
    methods: {
        getImage(item) {
            return item.image;
        }
    }
}
</script>
