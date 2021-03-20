<template>
<v-container fluid>

    <!--course list-->
    <v-data-table :headers="headers" :items="payment" class="elevation-1" :footer-props="{ itemsPerPageOptions: [5, 10, 15],itemsPerPageText:'Category per page' }"
            :loading="loading"
            loading-text="Loading.....Please wait.">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                    <v-card-actions>
                        {{payment.length}}
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>Payment Gateways</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <!--add new category-->
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on:dialog,attrs }">
                        <v-tooltip top>
                            <template v-slot:activator="{ on:tooltip }">
                                <v-btn class="mr-2 float-right" fab dark color="success" v-bind="attrs" v-on="{...dialog,...tooltip}">
                                    <v-icon dark>mdi-plus</v-icon>
                                </v-btn>
                            </template>
                            <span>Add New</span>
                        </v-tooltip>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{
                                        formTitle
                                    }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <v-form ref="form" v-model="valid">
                                            <v-text-field v-model="editedItem.gateway_name" :rules="[validRules.required]" label="Payment gateway name"></v-text-field>
                                        </v-form>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <!--end add new-->
            </v-toolbar>
        </template>
        <!--course item actions-->
        <template v-slot:item.actions="{ item }">

            <!--edit button-->
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon small class="mr-2" @click="editItem(item)" v-bind="attrs" v-on="on">
                        mdi-pencil
                    </v-icon>
                </template>
                <span>Edit</span>
            </v-tooltip>
            <!--end edit button-->

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
                    <v-card-title class="headline">Warning!!!!</v-card-title>
                    <v-card-text>Deleting this may effect related products.Are you sure you want to delete this item?</v-card-text>
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

    <!--snackbar for data update message-->
    <v-snackbar v-model="dataUpdateAlert" :color="alertColor" :timeout="timeout">
        <v-icon color="white" style="margin-right:10px">mdi-checkbox-marked-circle</v-icon>
        {{dataUpdateMsg}}
        <v-btn color="white" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
    <!--end snackbar-->

</v-container>
</template>

<script>
import {
    mapState, mapMutations
} from 'vuex';
import {
    mapFields
} from 'vuex-map-fields';
export default {

    data() {
        return {
            loading:true,
            valid: true,
            alertColor: 'success',
            timeout: 2000,
            dataUpdateMsg: '',
            dataUpdateAlert: false,
            deleteDialog: false,
            details: [],
            dialog: false,
            payment:[],
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Gateway Name',
                    value: 'gateway_name'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            editedIndex: -1,
            editedItem: {
                id: '',
                gateway_name: '',
            },
            defaultItem: {
                id: '',
                gateway_name: '',
            },
        }
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Gateway' : 'Edit Gateway'
        },
        
        ...mapState({
            'validRules': state => state.validation.validRules,
        }),

    },
    watch: {
        dialog(val) {
            val || this.close()
        },
    },
    mounted(){
        this.initialize()
    },

    methods: {
        initialize(){
            axios
                .get("/api/payment") //see the response to understand this-page urls
                .then(res => {
                    this.payment=res.data
                    console.log(this.payment)
                    this.loading=false
                })
                .catch(err => console.log(err.response));
        },

        editItem(item) {
            this.editedIndex = this.payment.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.payment.indexOf(item)
            this.payment.splice(index, 1)
            axios.delete('/api/deleteCategory/' + item.id)
                .then(this.deleteDialog = false,
                    this.dataUpdateMsg = 'Course item deleted successfully',
                    this.dataUpdateAlert = true
                )
        },

        focusMessage() {
            this.errors = []
        },
        close() {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save() {
            if (this.$refs.form.validate()) {
                if (this.editedIndex > -1) {
                    axios.put('/api/payment/' + this.editedItem.id, {
                            'gateway_name': this.editedItem.gateway_name,
                        })
                        .then(res => {
                            this.payment.splice(this.editedIndex,1, res.data)
                                this.close()
                                this.dataUpdateMsg = 'Category item updated successfully'
                                this.dataUpdateAlert = true
                        })
                        .catch(err => console.log(err.response))
                } else {

                    axios.post('/api/payment', {
                            'gateway_name': this.editedItem.gateway_name,
                        })
                        .then(res => {
                            this.payment.push(res.data) 
                                this.close()
                                this.dataUpdateMsg = 'New Category Added successfully',
                                this.dataUpdateAlert = true
                        }).catch(err => console.log(err.response))
                }
            }
        },
    },

}
</script>
