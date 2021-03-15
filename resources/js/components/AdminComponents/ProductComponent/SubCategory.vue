<template>
<v-container fluid>

    <!--course list-->
    <v-data-table :headers="headers" :items="subcategories.data" class="elevation-1" :footer-props="{ itemsPerPageOptions: [5, 10, 15],itemsPerPageText:'Sub-Category per page' }"
            :server-items-length="subcategories.total"
            :loading="loading"
            loading-text="Loading.....Please wait."
            @pagination="paginate">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-toolbar-title>Product SubCategories</v-toolbar-title>
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
                                        <v-form v-model="valid" ref="form">
                                            <v-select v-model="editedItem.category_id" :rules="[validRules.required]" :items="categories" label="Category" item-text="category_name" item-value="id"></v-select>
                                            <v-text-field v-model="editedItem.subCategory_name" :rules="[validRules.required]" label="Category Name"></v-text-field>
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
            <v-btn color="primary" @click="paginate">Reset</v-btn>
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
    mapState
} from 'vuex';
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
            categories:[],
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Category Name',
                    value: 'category.category_name'
                },
                {
                    text: 'Sub-category Name',
                    value: 'subCategory_name'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            subcategories: [],
            editedIndex: -1,
            editedItem: {
                id: '',
                category_id: '',
                subCategory_name: '',
            },
            defaultItem: {
                id: '',
                category_id: '',
                subCategory_name: '',
            },
        }
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Category' : 'Edit Category'
        },
        ...mapState({
            'validRules': state => state.validation.validRules
        }),

    },
    mounted(){
        this.getCategories()
    },
    watch: {
        dialog(val) {
            val || this.close()
        },
    },
    methods: {
        paginate($event){
            axios
                .post("/api/getSubCategories?page="+$event.page, {'per_page':$event.itemsPerPage}) //see the response to understand this-page urls
                .then(res => {
                    this.subcategories = res.data;
                    console.log('sub:',this.subcategories)
                    this.loading=false
                })
                .catch(err => console.log(err.response));
        },

        editItem(item) {
            this.editedIndex = this.subcategories.data.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.subcategories.data.indexOf(item)
            this.subcategories.data.splice(index, 1)
            axios.delete('/api/subcategories/' + item.id)
                .then(this.deleteDialog = false,
                    this.dataUpdateMsg = 'Course item deleted successfully',
                    this.dataUpdateAlert = true
                )
        },
        getCategories() {
            axios.get('api/getCategories')
                .then(res => {
                    this.categories = res.data
                })
                .catch(err => console.log(err.response))
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
                    axios.put('/api/subcategories/' + this.editedItem.id, {
                            'category_id': this.editedItem.category_id,
                            'subCategory_name': this.editedItem.subCategory_name
                        })
                        .then(res => {
                            if (Object.assign(this.subcategories.data[this.editedIndex], res.data.subcategories)) {
                                this.close()
                                this.dataUpdateMsg = 'Category item updated successfully'
                                this.dataUpdateAlert = true
                            }
                        })
                        .catch(err => console.log(err.response))
                    Object.assign(this.subcategories[this.editedIndex], this.editedItem)
                } else {

                    axios.post('/api/subcategories', {
                            'category_id': this.editedItem.category_id,
                            'subCategory_name': this.editedItem.subCategory_name
                        })
                        .then(res => {
                            if (this.subcategories.data.push(res.data)) {
                                this.close()
                                this.dataUpdateMsg = 'New Category Added successfully',
                                    this.dataUpdateAlert = true
                            }
                        }).catch(err => console.log(err.response))
                }
            }
        },
    },

}
</script>
