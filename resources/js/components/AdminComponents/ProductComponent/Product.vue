<template>
<v-container fluid>

    <!--heading-->
    <v-row justify="center">
        <p class="headline text-lg-center font-weight-bold">Products</p>
    </v-row>
    <!--end heading-->

    <!--course list-->
    <v-data-table :headers="headers" :items="products" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                    <v-card-actions>
                        <v-icon x-large color="white">mdi-account-star</v-icon>
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>Products Management</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <!--add new course-->
                <v-tooltip top>
                    <template v-slot:activator="{ on:tooltip }">
                        <v-btn class="mr-2 float-right" fab dark color="success" v-on="{...tooltip}" @click="addDialog">
                            <v-icon dark>mdi-plus</v-icon>
                        </v-btn>
                    </template>
                    <span>Add New</span>
                </v-tooltip>
                <!--end add new-->
            </v-toolbar>
        </template>
        <!--course item actions-->
        <template v-slot:item.actions="{ item }">
            <!--view button-->
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon small class="mr-2" @click="goTodetail(item)" v-bind="attrs" v-on="on">
                        mdi-eye
                    </v-icon>
                </template>
                <span>View details</span>
            </v-tooltip>

            <!--end view button-->

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

    <!-- product add dialog -->
    <v-dialog v-model="productDialog" max-width="1200px" persistent>
        <v-card>
            <v-card-title>
                <span class="headline">{{
                                        formTitle
                                    }}</span>
            </v-card-title>

            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field v-model="editedItem.title" label="Product Name" dense></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field v-model="editedItem.price" label="Price" dense></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>

                        <v-col cols="4">
                            <v-select v-model="editedItem.category" :items="category" label="Category" item-text="category_name" item-value="id" dense></v-select>
                        </v-col>
                        <v-col cols="4">
                            <v-select v-model="editedItem.subCategory" :items="subCategory" label="Sub-Category" item-text="subCategory_name" item-value="id" dense></v-select>
                        </v-col>
                        <v-col cols="4">
                            <v-select v-model="editedItem.company" :items="company" label="Company" item-text="company_name" item-value="id" dense></v-select>

                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="4">
                            <v-select v-model="editedItem.selectedSize" :items="size" chips small-chips multiple dense label="Available sizes" item-text="size" item-value="id"></v-select>
                        </v-col>
                        <v-col cols="4">
                            <v-select v-model="editedItem.selectedColor" :items="color" chips small-chips multiple dense label="Available color" item-text="color_name" item-value="id"></v-select>
                        </v-col>
                        <v-col cols="4">
                            <v-select v-model="editedItem.type" :items="productType" label="Product Type" item-text="product_type" item-value="id" dense></v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-file-input v-model="files" label="Upload photos" multiple dense @change="onFileChanged">
                                <template v-slot:selection="{ text }">
                                    <v-chip small label color="primary">
                                        {{ text }}
                                    </v-chip>
                                </template>
                            </v-file-input>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <froala id="edit" :tag="'textarea'" :config="config" v-model="editedItem.description"></froala>
                        </v-col>
                        <v-col cols="6">
                            <v-select v-model="editedItem.selectedTag" :items="tag" label="Select Tags" chips small-chips multiple item-text="tag_name" item-value="id" dense></v-select>

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
    <!-- end product add dialog -->

</v-container>
</template>

<script>
import VueFroala from 'vue-froala-wysiwyg';
import {
    mapState
} from 'vuex';
export default {

    data() {
        return {
            valid: true,
            tagItem: [],
            config: {
                quickInsertEnabled: false,

                toolbarButtons: {
                    // name for block of buttons

                    moreParagraph: {
                        buttons: ['paragraphFormat', 'formatOLSimple', 'formatUL', 'alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'lineHeight', ],
                        align: 'left',
                        buttonsVisible: 8
                    },
                    moreText: {
                        // buttons you need on this block
                        buttons: ['bold', 'italic', 'underline'],
                        align: 'left',
                        buttonsVisible: 3
                    },
                },

            },
            files: [],

            selectedFile: null,
            isSelecting: false,
            url: null,

            alertColor: 'success',
            timeout: 2000,
            dataUpdateMsg: '',
            dataUpdateAlert: false,
            deleteDialog: false,

            productDialog: false,
            category: [],
            subCategory: [],
            productType: [],
            company: [],
            size: [],
            color: [],
            tag: [],
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Title',
                    value: 'title'
                },
                {
                    text: 'Price',
                    value: 'price'
                },
                {
                    text: 'Category',
                    value: 'title'
                },
                {
                    text: 'Sub-Category',
                    value: 'title'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            products: [],
            editedIndex: -1,
            editedItem: {
                id: '',
                title: '',
                price: '',
                category: '',
                subCategory: '',
                type: '',
                company: '',
                description: '',
                selectedColor: [],
                selectedSize: [],
                selectedTag: []

            },
            defaultItem: {
                id: '',
                title: '',
                price: '',
                category: '',
                subCategory: '',
                type: '',
                company: '',
                description: '',
                selectedColor: [],
                selectedSize: [],
                selectedTag: []
            },
        }
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Product' : 'Edit Product'
        },
        ...mapState({
            validRules: state => state.validation.validRules

        })
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
        addDialog() {
            this.productDialog = true
            this.getProductSup()
        },
        getProductSup() {
            axios.get('/api/getProductSup', {}).
            then(res => {
                    this.category = res.data.category
                    this.subCategory = res.data.subCategory
                    this.company = res.data.company
                    this.productType = res.data.productType
                    this.size = res.data.size,
                        this.color = res.data.color,
                        this.tag = res.data.tag

                })
                .catch(err => console.log(err.response))
        },
        initialize() {
            axios.get('/api/products', {}).
            then(res => this.products = res.data)
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.products.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.products.indexOf(item)
            this.products.splice(index, 1)
            axios.delete('/api/products/' + item.id)
                .then(this.deleteDialog = false,
                    this.dataUpdateMsg = 'Course item deleted successfully',
                    this.dataUpdateAlert = true
                )
        },

        close() {
            this.productDialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save() {
            if (this.editedIndex > -1) {
                axios.put('/api/products/' + this.editedItem.id, {
                        'title': this.editedItem.title,
                        'price': this.editedItem.price,
                        'product_type_id': this.editedItem.type,
                        'category_id': this.editedItem.category,
                        'subCategory_id': this.editedItem.subCategory,
                        'company_id': this.editedItem.company,
                        'description': this.editedItem.description,
                        'color_name': this.editedItem.selectedColor,
                        'size': this.editedItem.selectedSize,
                        'tag_name': this.editItem.selectedTag
                    })
                    .then(res => {
                        if (Object.assign(this.products[this.editedIndex], res.data)) {
                            this.close()
                            this.dataUpdateMsg = 'Product item updated successfully'
                            this.dataUpdateAlert = true
                        }
                    })
                    .catch(err => {
                        console.log(err.response)
                    })
                Object.assign(this.products[this.editedIndex], this.editedItem)
            } else {

                axios.post('/api/products', {
                        'title': this.editedItem.title,
                        'price': this.editedItem.price,
                        'product_type_id': this.editedItem.type,
                        'category_id': this.editedItem.category,
                        'subCategory_id': this.editedItem.subCategory,
                        'company_id': this.editedItem.company,
                        'description': this.editedItem.description,
                        'color_name': this.editedItem.selectedColor,
                        'size': this.editedItem.selectedSize,
                        'tag_name': this.editedItem.selectedTag
                    })
                    .then(res => {
                        if (this.products.push(res.data)) {
                            this.close()
                            this.dataUpdateMsg = 'New Product Added successfully',
                                this.dataUpdateAlert = true
                        }
                    }).catch(err => {
                        console.log(err.response)
                    })
            }
        },
        onFileChanged(e) {
            console.log(e.target.files[0]);
            const file = e.target.files[0];
            this.selectedFile = e.target.files[0];
            this.url = URL.createObjectURL(file);
            this.changeIconDialog = true;
        },
        updateCourseIcon(item) {
            this.changeIconDialog = false
            let data = new FormData()
            data.append('selectedFile', this.selectedFile, this.selectedFile.name)
            data.append('id', item.id)
            let settings = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            axios.post('api/savePhotos', data, settings)
                .then(res => {
                    this.products.push(res.data.products)
                }).catch(err => {
                    console.log(err.response)
                });

        },
    },

}
</script>
