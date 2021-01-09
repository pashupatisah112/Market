<template>
<v-container fluid>

    <!--heading-->
    <v-row class="mt-5" justify="center">
        <p class="headline text-lg-center font-weight-bold"></p>
    </v-row>
    <!--end heading-->

    <!--course list-->
    <v-data-table :headers="headers" :items="categories" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                    <v-card-actions>
                        <v-icon x-large color="white">mdi-account-star</v-icon>
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>Product Categories</v-toolbar-title>
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
                                        <v-text-field v-model="editedItem.category_name" label="Category Name"></v-text-field>
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
import {mapState} from 'vuex';
import {mapFields} from 'vuex-map-fields';
export default {

    data() {
        return {
            alertColor: 'success',
            timeout: 2000,
            dataUpdateMsg: '',
            dataUpdateAlert: false,
            deleteDialog: false,
            details: [],
            dialog: false,
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Category Name',
                    value: 'category_name'
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
                category_name: '',
            },
            defaultItem: {
                id: '',
                category_name: '',
            },
        }
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Category' : 'Edit Category'
        },
        ...mapState(['categories']),
        ...mapFields(['categories'])

    },
    watch: {
        dialog(val) {
            val || this.close()
        },
    },

    created() {
        this.initialize()
    },
    mounted() {

    },
    methods: {
        initialize() {
            axios.get('/api/categories', {}).
            then(res => this.categories = res.data)
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.categories.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.categories.indexOf(item)
            this.categories.splice(index, 1)
            axios.delete('/api/categories/' + item.id)
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
            if (this.editedIndex > -1) {
                axios.put('/api/categories/' + this.editedItem.id, {
                        'category_name': this.editedItem.category_name,
                    })
                    .then(res => {
                        if (Object.assign(this.categories[this.editedIndex], res.data.categories)) {
                            this.close()
                            this.dataUpdateMsg = 'Category item updated successfully'
                            this.dataUpdateAlert = true
                        }
                    })
                    .catch(err => console.log(err.response))
                Object.assign(this.categories[this.editedIndex], this.editedItem)
            } else {

                axios.post('/api/categories', {
                        'category_name': this.editedItem.category_name,
                    })
                    .then(res => {
                        if (this.categories.push(res.data)) {
                            this.close()
                            this.dataUpdateMsg = 'New Category Added successfully',
                                this.dataUpdateAlert = true
                        }
                    }).catch(err => console.log(err.response))
            }
        },
    },

}
</script>
