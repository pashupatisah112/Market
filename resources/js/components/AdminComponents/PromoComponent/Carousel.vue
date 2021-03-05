<template>
<v-container fluid>
    <!--course list-->
    <v-data-table :headers="headers" :items="featured.data" sort-by="calories" class="elevation-1" :footer-props="{ itemsPerPageOptions: [5, 10, 15],itemsPerPageText:'Promo per page' }"
            :server-items-length="featured.total"
            :loading="loading"
            loading-text="Loading.....Please wait."
            @pagination="paginate">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-toolbar-title>Featured Product Management</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <!--add new featured-->
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
                                            <v-text-field v-model="editedItem.preTag" label="Pre-tag" outlined dense :rules="[validRules.required]"></v-text-field>
                                            <v-text-field v-model="editedItem.promoTitle" label="Featured Title" outlined dense :rules="[validRules.required]"></v-text-field>
                                            <v-select v-model="
                                                        editedItem.product_id
                                                    " :items="products" item-text="title" item-value="id" label="Select product" outlined dense :rules="[validRules.required]"></v-select>
                                            <v-textarea outlined v-model="editedItem.description" label="Short Description" :auto-grow="true" :clearable="true" :rows="1"></v-textarea>
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
        <!--featured item actions-->
        <template v-slot:item.actions="{ item }">
            <!--view button-->
            <v-tooltip top>
                <template v-slot:activator="{ on: tooltip }">
                    <v-btn icon v-on="{ ...tooltip }" @click="showImages(item)">
                        <v-icon small class="mr-2">
                            mdi-image
                        </v-icon>
                    </v-btn>
                </template>
                <span>View Image</span>
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

    <!--image view dialog-->
    <v-dialog v-model="imageViewDialog" max-width="800px" persistent>
        <v-card>
            <v-btn icon @click="imageViewDialog = false" class="float-right">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-card-title>
                {{ selectedItem.title }}
            </v-card-title>
            <v-container fluid>
                <v-row justify="center">
                    <v-col cols="12" align="center">
                        <v-img :src="getImage(selectedItem)" :aspect-ratio="9/16" alt="Primary img"></v-img>
                        <div>
                            <div v-if="selectedItem.image==null">
                                <v-btn icon outlined x-large @click="onButtonClick" :loading="isSelecting" class="mt-2">
                                    <v-icon>mdi-image-plus</v-icon>
                                </v-btn>
                                <input ref="uploader" class="d-none" type="file" accept="image/*" @change="onFileChanged" />
                                <p>Add image</p>
                            </div>
                            <div v-else>
                                <v-btn icon outlined x-large class="mt-2" @click="onButtonClick" :loading="isSelecting">
                                    <v-icon>mdi-image-plus</v-icon>
                                </v-btn>
                                <input ref="uploader" class="d-none" type="file" accept="image/*" @change="onFileChanged" />
                                <p>Change image</p>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
    <!--end image view dialog-->

</v-container>
</template>

<script>
import {
    mapState
} from 'vuex'
import firebase from 'firebase'
export default {
    data() {
        return {
            loading:true,
            //form
            valid: true,

            //image
            selectedFile: null,
            isSelecting: false,
            selectedItem: {
                title: ''
            },
            selectedIndex: null,
            imageViewDialog: false,

            //dialog
            alertColor: 'success',
            timeout: 2000,
            dataUpdateMsg: '',
            dataUpdateAlert: false,
            deleteDialog: false,

            dialog: false,

            //headers
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Title',
                    value: 'promoTitle'
                },
                {
                    text: 'Pretag',
                    value: 'preTag'
                },
                {
                    text: 'Description',
                    value: 'description'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            featured: [],
            products: [],
            editedIndex: -1,
            editedItem: {
                id: '',
                preTag: '',
                promoTitle: '',
                description: '',
                product_id: '',
                image: ''
            },
            defaultItem: {
                id: '',
                preTag: '',
                promoTitle: '',
                description: '',
                product_id: '',
                image: ''
            },
        }
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Featured' : 'Edit Featured'
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
        this.getProducts()
    },
    methods: {
        getProducts() {
            axios.get('/api/getProductsFeatured', {}).
            then(res => {
                    this.products = res.data
                })
                .catch(err => console.log(err.response))
        },
        paginate($event){
            axios
                .post("/api/getFeatured?page="+$event.page, {'per_page':$event.itemsPerPage}) //see the response to understand this-page urls
                .then(res => {
                    this.featured = res.data;
                    this.loading=false
                })
                .catch(err => console.log(err.response));
        },

        editItem(item) {
            this.editedIndex = this.featured.data.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.featured.data.indexOf(item)
            this.featured.data.splice(index, 1)
            axios.delete('/api/featured/' + item.id)
                .then(this.deleteDialog = false,
                    this.dataUpdateMsg = 'Course item deleted successfully',
                    this.dataUpdateAlert = true,
                    this.featured.splice(this.featured.indexOf(item), 1)
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
                axios.put('/api/featured/' + this.editedItem.id, {
                        'preTag': this.editedItem.preTag,
                        'promoTitle': this.editedItem.promoTitle,
                        'product_id': this.editedItem.product_id,
                        'description': this.editedItem.description,
                    })
                    .then(res => {
                        if (Object.assign(this.featured.data[this.editedIndex], res.data.featured)) {
                            this.close()
                            this.dataUpdateMsg = 'Course item updated successfully'
                            this.dataUpdateAlert = true
                        }
                        this.$refs.form.reset()
                    })
                    .catch(err => {
                        if (err.response.status == 422) {
                            this.errCourse = err.response.data.errors.course_name
                        }
                    })
                Object.assign(this.featured.data[this.editedIndex], this.editedItem)
            } else {

                axios.post('/api/featured', {
                        'preTag': this.editedItem.preTag,
                        'promoTitle': this.editedItem.promoTitle,
                        'product_id': this.editedItem.product_id,
                        'description': this.editedItem.description,
                    })
                    .then(res => {
                        if (this.featured.data.push(res.data)) {
                            this.close()
                            this.dataUpdateMsg = 'New Course Added successfully',
                                this.dataUpdateAlert = true
                        }
                        this.$refs.form.reset()
                    }).catch(err => {
                        if (err.response.status == 422) {
                            this.errCourse =
                                err.response.data.errors.course_name
                        }
                    })
            }
        },
        showImages(item) {
            this.selectedIndex = this.products.indexOf(item)
            this.selectedItem = item;
            this.imageViewDialog = true;

        },
        onButtonClick() {
            this.isSelecting = true;
            window.addEventListener(
                "focus",
                () => {
                    this.isSelecting = false;
                }, {
                    once: true
                }
            );

            this.$refs.uploader.click();
        },
        onFileChanged(e) {
            let file = e.target.files[0]
            console.log(file.name)
            var storageRef = firebase.storage().ref('productImage/' + file.name); //prductImages is folder created in firebase in storage/files section
             this.uploadTask = storageRef.put(file)
             this.addFeaturedImage();
        },
        addFeaturedImage() {
            this.uploadTask.on('state_changed', function (snapshot) {

            }, (error) => {
                //if 403 errors change rules in firebabse
                //allow read, write: if request.auth == null;
                //later authentication should be implemented this is just for testing
                console.log(error)
            }, () => {
                this.uploadTask.snapshot.ref.getDownloadURL().then((downloadURL) => { //here => has been used to get access with 'this' keyword
                    let image = downloadURL
                    axios
                        .post("api/addFeaturedImage", {
                            id: this.selectedItem.id,
                            photo: image
                        })
                        .then(res => {
                            console.log(res.data)
                             this.selectedItem = res.data
                             this.products.splice(this.selectedIndex, 1, res.data)
                        })
                        .catch(err => {
                            console.log(err.response);
                        });
                })
            })
        },
        getImage(selectedItem) {
            return selectedItem.photo;
        },

    },

}
</script>
