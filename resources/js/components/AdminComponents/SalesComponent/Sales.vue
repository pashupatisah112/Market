<template>
<v-container fluid>
    <!--course list-->
    <v-data-table :headers="headers" :items="sales" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-toolbar-title>Sales Management</v-toolbar-title>
            </v-toolbar>
        </template>
        <!--sales item actions-->
        <template v-slot:item.actions="{ item }">

            <!--deliver button-->
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <v-switch v-model="status" :label="`Status: ${status.toString()}`" @click="changeDeliveryStatus(item)" v-bind="attrs" v-on="on"></v-switch>
                </template>
                <span>Change Status</span>
            </v-tooltip>

            <!--deliver button-->

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
                <template v-slot:activator="{ on:dialog, attrs }">
                    <v-tooltip top>
                        <template v-slot:activator="{ on:tooltip }">
                            <v-icon small @click="deleteDialog = true" v-bind="attrs" v-on="{...dialog,...tooltip}">
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Delete</span>
                    </v-tooltip>
                </template>
                <v-card>
                    <v-card-title class="headline">Delete Confirmation</v-card-title>
                    <v-card-text>Are you sure you want to delete this Course?</v-card-text>
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

</v-container>
</template>

<script>
export default {

    data() {
        return {
            //form
            status:'Not Delivered',


            deleteDialog: false,

            //headers
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'User',
                    value: 'user.name'
                },
                {
                    text: 'Total',
                    value: 'total'
                },
                {
                    text: 'Address',
                    value: 'address'
                },
                {
                    text: 'Status',
                    value: 'address'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            sales: [],
        }
    },

    created() {
        this.initialize()
    },
    methods: {
        initialize() {
            axios.get('/api/sales', {}).
            then(res => {
                    this.sales = res.data
                    console.log(this.sales)
                })
                .catch(err => console.log(err.response))

        },
        changeDeliveryStatus(item) {
            
        },
        deleteItem(item) {
            const index = this.sales.indexOf(item)
            this.sales.splice(index, 1)
            axios.post('/api/deleteComment/', {
                    comment_id: item.id
                })
                .then(res => {
                    this.deleteDialog = false
                    console.log(res.data)
                }).catch(err => console.log(err.response))

        },
    },

}
</script>
