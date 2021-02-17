<template>
<v-container fluid>
    <!--course list-->
    <v-data-table :headers="headers" :items="orders">
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>Orders Management</v-toolbar-title>
            </v-toolbar>
        </template>
        <!--orders item actions-->
        <template v-slot:item.actions="{ item }">
            <!--deliver button-->
            <v-select v-model="delivery_status" :items="statusList" label="Change Delivery Status" item-text="status" item-value="status" dense outlined class="mt-2 mb-n5" @change="changeDeliveryStatus(item)"></v-select>
            <!--deliver button-->

            <!--View sale-->
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon small class="mr-2" @click="viewOrder(item)" v-bind="attrs" v-on="on">
                        mdi-eye
                    </v-icon>
                </template>
                <span>ViewDetail</span>
            </v-tooltip>
            <!--end view sale-->

            <!--invoice button-->
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon small class="mr-2" @click="printInvoice(item)" v-bind="attrs" v-on="on">
                        mdi-printer
                    </v-icon>
                </template>
                <span>Print invoice</span>
            </v-tooltip>

            <!--end invoice button-->

            <!--delete section-->
            <v-dialog v-model="deleteDialog" persistent max-width="400" :retain-focus="false">
                <!--retain-focus helps prevent from maximum exceeding error caused when two items are deleted continuously. this is a bug so add this props compulsarily-->
                <template v-slot:activator="{ on: dialog, attrs }">
                    <v-tooltip top>
                        <template v-slot:activator="{ on: tooltip }">
                            <v-icon small @click="deleteDialog = true" v-bind="attrs" v-on="{ ...dialog, ...tooltip }">
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Delete</span>
                    </v-tooltip>
                </template>
                <v-card>
                    <v-card-title class="headline">Delete Confirmation</v-card-title>
                    <v-card-text>Are you sure you want to delete this
                        Course?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="deleteDialog = false">Cancel</v-btn>
                        <v-btn color="green darken-1" text @click="deleteItem(item)">Confirm</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!--end delete section-->
        </template>
        <!--end action-->
        <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
    </v-data-table>
    <!--end course list-->

    <!--order view dialog-->
    <v-dialog v-model="orderViewDialog" max-width="800">
        <v-card>
            <v-card-title>
                {{ selectedOrder.order_id }}
            </v-card-title>
            <v-card-text>
                <p class="body-1">Customer Details</p>
                <p>
                    <span class="font-weight-bold">Customer Name:</span>
                    {{ selectedOrder.user }}
                </p>
                <p class="mt-n3">
                    <span class="font-weight-bold">Address:</span>
                    {{ selectedOrder.address }}
                </p>
                <p class="mt-n3">
                    <span class="font-weight-bold">Phone:</span>
                    {{ selectedOrder.phone }}
                </p>

                <p class="body-1">Product Details</p>
                <v-simple-table class="border">
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
                            <tr v-for="item in orderedProducts" :key="item.id">
                                <td>
                                    <v-list two-line dense>
                                        <v-list-item>
                                            <v-list-item-avatar tile size="60">
                                                <v-img :src="
                                                            getImage(
                                                                item.product
                                                            )
                                                        "></v-img>
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title v-text="
                                                            item.product.title
                                                        "></v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                </td>
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
            </v-card-text>
            <v-card-actions> </v-card-actions>
        </v-card>
    </v-dialog>
    <!--end order view dialog-->

    <!-- status confirm dialog -->
    <v-dialog v-model="statusConfirmDialog" max-width="400" persistent>
        <v-card>
            <v-card-title>
                Confirm Status Change
            </v-card-title>
            <v-card-text>
                Are you sure you want to change the delivery status to '{{
                        delivery_status
                    }}'?
            </v-card-text>
            <v-card-actions>
                <v-btn dark rounded small class="text-capitalize" @click="statusConfirmDialog = false">Cancel</v-btn>
                <v-spacer></v-spacer>
                <v-btn dark rounded small class="text-capitalize" @click="confirmDeliveryChange">Confirm</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <!-- end status confirm dialog -->
</v-container>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'
import {
    mapMutations,
    mapState
} from 'vuex';
export default {
    components: {
        VueHtml2pdf
    },
    data() {
        return {
            delivery_status: "",
            orderViewDialog: false,
            selectedOrder: [],
            orderedProducts: [],
            statusConfirmDialog: false,

            statusList: [{
                id: 1,
                status: 'Pending'
            }, {
                id: 2,
                status: 'Delivered'
            }, {
                id: 3,
                status: 'Cancelled'
            }],
            //form
            status: "Not Delivered",

            deleteDialog: false,

            //headers
            headers: [{
                    text: "Order ID",
                    align: "start",
                    sortable: false,
                    value: "order_id"
                },
                {
                    text: "User",
                    value: "user.name"
                },
                {
                    text: "Address",
                    value: "address"
                },
                {
                    text: "Payment",
                    value: "payment_gateway.gateway_name"
                },
                {
                    text: "Delivery Status",
                    value: "delivery_status"
                },
                {
                    text: "Actions",
                    value: "actions",
                    sortable: false
                }
            ],
            orders: []
        };
    },

    created() {
        this.initialize();
    },
    methods: {
        ...mapMutations(['setupInvoiceOrder', 'setupInvoiceProduct', 'setupInvoiceTotal']),
        initialize() {
            axios
                .get("/api/orders", {})
                .then(res => {
                    this.orders = res.data;
                })
                .catch(err => console.log(err.response));
        },
        changeDeliveryStatus(item) {
            this.selectedOrder = item;
            this.statusConfirmDialog = true;
        },
        confirmDeliveryChange() {
            axios
                .post("api/changeDeliveryStatus", {
                    id: this.selectedOrder.id,
                    status: this.delivery_status
                })
                .then(res => {
                    this.orders.splice(
                        this.orders.indexOf(this.selectedOrder),
                        1,
                        res.data
                    );
                    this.statusConfirmDialog = false;
                    this.delivery_status = ''
                })
                .catch(err => console.log(err.response));
        },
        viewOrder(item) {
            this.selectedOrder = item;
            axios
                .post("api/getOrderDetail", {
                    order_id: item.id
                })
                .then(res => {
                    this.orderedProducts = res.data.sale;
                    console.log(this.orderedProducts);
                })
                .catch(err => console.log(err.response));
            this.orderViewDialog = true;
        },
        printInvoice(item) {
            this.selectedOrder = item
            this.total_delivery_charge = item.delivery_charge
            axios
                .post("api/getOrderDetail", {
                    order_id: item.id
                })
                .then(res => {
                    this.orderedProducts = res.data.sale;
                    this.totalBill = res.data.total
                    this.setupInvoiceOrder(this.selectedOrder)
                    this.setupInvoiceProduct(this.orderedProducts)
                    this.setupInvoiceTotal(this.totalBill)

                    let routeData = this.$router.resolve({
                        name: 'Invoice',
                    });
                    window.open(routeData.href, '_blank');

                })
                .catch(err => console.log(err.response));

        },
        deleteItem(item) {
            this.selectedOrder = item
            const index = this.orders.indexOf(item);
            this.orders.splice(index, 1);
            axios
                .post("/api/deleteOrder/", {
                    'id': this.selectedOrder.id
                })
                .then(res => {
                    this.deleteDialog = false;
                })
                .catch(err => console.log(err.response));
        },
        getImage(item) {
            return item.image;
        },
    }
};
</script>
