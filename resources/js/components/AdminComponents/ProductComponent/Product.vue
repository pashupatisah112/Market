<template>
<v-container fluid>
    <!--course list-->
    <v-data-table :headers="headers" :items="products.data" class="elevation-1" :footer-props="{ itemsPerPageOptions: [5, 10, 15],itemsPerPageText:'Products per page' }" :server-items-length="products.total" :loading="loading" loading-text="Loading.....Please wait." @pagination="paginate">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-toolbar-title>Products Management</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <!--add new course-->
                <v-dialog v-model="productDialog" max-width="1200px" persistent>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn class="mr-2 float-right" fab dark color="success" v-bind="attrs" v-on="on">
                            <v-icon dark>mdi-plus</v-icon>
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-form ref="form" v-model="valid">
                                    <v-row>
                                        <v-col cols="4">
                                            <v-text-field v-model="editedItem.title" label="Product Name" dense :rules="[
                                                        validRules.required
                                                    ]"></v-text-field>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-text-field v-model="editedItem.price" type="number" label="Price" dense :rules="[
                                                        validRules.required
                                                    ]"></v-text-field>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-text-field v-model="
                                                        editedItem.product_code
                                                    " :error-messages="
                                                        productCodeError
                                                    " label="Product code" dense :rules="[
                                                        validRules.required
                                                    ]"></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4">
                                            <v-select v-model="
                                                        editedItem.category
                                                    " :items="category" label="Category" item-text="category_name" item-value="id" dense :rules="[
                                                        validRules.required
                                                    ]"></v-select>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-select v-model="
                                                        editedItem.sub_category
                                                    " :items="subCategory" label="Sub-Category" item-text="subCategory_name" item-value="id" dense :rules="[
                                                        validRules.required
                                                    ]"></v-select>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-select v-model="editedItem.company" :items="company" label="Company" item-text="company_name" item-value="id" dense :rules="[
                                                        validRules.required
                                                    ]"></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="4">
                                            <v-select v-model="
                                                        editedItem.selectedSize
                                                    " :items="size" chips small-chips multiple dense label="Available sizes" item-text="size" item-value="id" :rules="[
                                                        validRules.required
                                                    ]"></v-select>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-select v-model="
                                                        editedItem.selectedColor
                                                    " :items="color" chips small-chips multiple dense label="Available color" item-text="color_name" item-value="id" :rules="[
                                                        validRules.required
                                                    ]"></v-select>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-select v-model="
                                                        editedItem.product_type
                                                    " :items="productType" label="Product Type" item-text="product_type" item-value="id" dense :rules="[
                                                        validRules.required
                                                    ]"></v-select>
                                        </v-col>
                                    </v-row>

                                    <v-row>
                                        <v-col cols="12">
                                            <v-textarea outlined clearable placeholder="Enter your tags" rows="2" auto-grow="" @keyup.enter="enterTag" v-model="selectTag">
                                                <template slot="prepend-inner">
                                                    <v-chip close v-for="(item,
                                                            index) in enterSelectedTag" :key="index" @click:close="
                                                                removeTag(item)
                                                            ">
                                                        {{ item }}
                                                    </v-chip>
                                                </template>
                                            </v-textarea>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <froala id="edit" :tag="'textarea'" :config="config" v-model="
                                                        editedItem.description
                                                    " :rules="[
                                                        validRules.required
                                                    ]"></froala>
                                        </v-col>
                                    </v-row>
                                </v-form>
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
            <!--product view button-->
            <v-tooltip top>
                <template v-slot:activator="{ on: tooltip }">
                    <v-btn icon v-on="{ ...tooltip }" @click="viewProduct(item)">
                        <v-icon small class="mr-2">
                            mdi-eye
                        </v-icon>
                    </v-btn>
                </template>
                <span>View Product</span>
            </v-tooltip>

            <!--end view button-->

            <!-- image view button-->
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

            <!--status button-->
            <v-tooltip top>
                <template v-slot:activator="{ on: tooltip }">
                    <v-btn icon v-on="{ ...tooltip }" @click="changeProductStatus(item)">
                        <v-icon small class="mr-2">
                            mdi-circle-edit-outline
                        </v-icon>
                    </v-btn>
                </template>
                <span>change Status</span>
            </v-tooltip>
            <!--status button-->
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
        {{ dataUpdateMsg }}
        <v-btn color="white" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
    <!--end snackbar-->

    <!--product view dialog-->
    <v-dialog max-width="600" persistent v-model="productViewDialog">
        <v-card>
            <v-btn icon @click="productViewDialog = false" class="float-right">
                <v-icon>mdi-close</v-icon>
            </v-btn>

            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <p class="text-h5">Title: {{ view.title }}</p>
                        <h4>Price: {{ view.price }}</h4>
                        <h4>
                            Color:
                            <v-chip small v-for="item in view.color" :key="item.id" class="font-weight-light mx-1">{{ item.color_name + ", " }}</v-chip>
                        </h4>
                        <h4>
                            Size:
                            <v-chip small v-for="item in view.size" :key="item.id" class="font-weight-light mx-1">{{ item.size + ", " }}</v-chip>
                        </h4>
                        <h4>
                            <!-- for nested objects -->
                            Category: <span>{{view && view.category ? view.category.category_name : null}}</span>
                        </h4>
                        <h4>Sub category: {{view && view.subCategory ? view.sub_category.subCategory_name : null}}</h4>
                        <h4>Company: {{view && view.company ? view.company.company_name : null}}</h4>
                        <h4>Product code: {{ view.product_code }}</h4>
                        <h4>
                            Tags:
                            <v-chip small v-for="item in view.tag" :key="item.id" class="font-weight-light mx-1">{{ item.tag_name + ", " }}</v-chip>
                        </h4>
                        <h4>Description:<span class="body-2" v-html="view.description"></span></h4>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
    <!--end product view dialog-->

    <!--image view button-->
    <v-dialog v-model="imageViewDialog" max-width="800px" persistent>
        <v-card>
            <v-btn icon @click="imageViewDialog = false" class="float-right">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-card-title>
                {{ view.title }}
            </v-card-title>
            <v-container fluid>
                <v-row justify="center">
                    <v-col cols="4" align="center">
                        <div v-if="view.image">
                            <v-img :src="getImage(view)" alt="Primary img"></v-img>
                        </div>

                        <div>
                            <div v-if="view.image">
                                <v-btn icon outlined x-large class="mt-2" @click="onButtonClick" :loading="isSelecting">
                                    <v-icon>mdi-image-plus</v-icon>
                                </v-btn>
                                <input ref="uploader" class="d-none" type="file" accept="image/*" @change="onPrimaryChange" />
                                <p>Change primary image</p>
                            </div>
                            <div  v-else>
                                <v-btn icon outlined x-large @click="onButtonClick" :loading="isSelecting" class="mt-2">
                                    <v-icon>mdi-image-plus</v-icon>
                                </v-btn>
                                <input ref="uploader" class="d-none" type="file" accept="image/*" @change="onFileChanged" />
                                <p>Add primary image</p>
                            </div>
                            
                        </div>
                    </v-col>

                    <v-divider class="my-2" vertical></v-divider>

                    <v-col cols="7" align="center">
                        <v-row>
                            <v-col v-for="(item,index) in view.photo" :key="index">
                        
                                <div style="width:125px;height:auto">
                                    <v-btn icon @click="deleteSecImage(item)">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                    <v-img :src="getSecImage(item)" alt="sec img">
                                    </v-img>
                                </div>
                            </v-col>
                        </v-row>

                        <v-row justify="center">
                            <div class="mx-auto">
                                <v-btn icon outlined x-large @click="onSecondaryClick" :loading="isSecondarySelecting">
                                    <v-icon>mdi-image-plus</v-icon>
                                </v-btn>
                                <input ref="secondaryUploader" class="d-none" type="file" accept="image/*" @change="onSecondaryUpload" />
                                <p>Add secondary images</p>
                            </div>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
    <!--end image view button-->

    <!-- status change dialog -->
    <v-dialog v-model="confirmStatusChangeDialog" max-width="400" persistent>
        <v-card>
            <v-card-title>
                Confirm Status Change
            </v-card-title>
            <v-card-text>
                <v-form v-model="valid" ref="form">
                    <v-select v-model="product_status" :rules="[validRules.required]" :items="statusList" label="Change Product Status" placeholder="Change Product Status" item-text="status" item-value="status" dense outlined class="mt-2 mb-n5"></v-select>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn dark rounded small class="text-capitalize" @click="confirmStatusChangeDialog = false">Cancel</v-btn>
                <v-spacer></v-spacer>
                <v-btn dark rounded small class="text-capitalize" @click="confirmProductStatusChange">Confirm</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <!-- end status change dialog -->
</v-container>
</template>

<script>
import VueFroala from "vue-froala-wysiwyg";
import firebase from "firebase";
import {
    mapState
} from "vuex";
export default {
    data() {
        return {
            valid: true,
            loading: true,
            total: 0,
            view: [],
            productViewDialog: false,
            imageViewDialog: false,
            confirmStatusChangeDialog: false,

            selectedProduct: "",
            product_status: "",
            statusList: [{
                    id: 1,
                    status: "Online"
                },
                {
                    id: 2,
                    status: "Offline"
                },
                {
                    id: 3,
                    status: "Sale"
                }
            ],

            valid: true,
            tagItem: [],
            config: {
                quickInsertEnabled: false,

                toolbarButtons: {
                    // name for block of buttons

                    moreParagraph: {
                        buttons: [
                            "paragraphFormat",
                            "formatOLSimple",
                            "formatUL",
                            "alignLeft",
                            "alignCenter",
                            "alignRight",
                            "alignJustify",
                            "lineHeight"
                        ],
                        align: "left",
                        buttonsVisible: 8
                    },
                    moreText: {
                        // buttons you need on this block
                        buttons: ["bold", "italic", "underline"],
                        align: "left",
                        buttonsVisible: 3
                    }
                }
            },

            //image upload
            uploadTask: "",

            selectedFile: [],
            primary: null,
            secondary: null,
            isSelecting: false,
            isSecondarySelecting: false,
            selectedItem: "",
            selectedIndex: null,
            multiple: [],

            alertColor: "success",
            timeout: 2000,
            dataUpdateMsg: "",
            dataUpdateAlert: false,
            deleteDialog: false,

            productDialog: false,
            productCodeError: "",
            category: [],
            subCategory: [],
            productType: [],
            company: [],
            size: [],
            color: [],
            tag: [],

            enterSelectedTag: [],
            selectTag: "",
            headers: [{
                    text: "#",
                    align: "start",
                    sortable: false,
                    value: "id"
                },
                {
                    text: "Title",
                    value: "title"
                },
                {
                    text: "Price",
                    value: "price"
                },
                {
                    text: "Category",
                    value: "category.category_name"
                },
                {
                    text: "Sub-Category",
                    value: "sub_category.subCategory_name"
                },
                {
                    text: "Status",
                    value: "status"
                },
                {
                    text: "Actions",
                    value: "actions",
                    sortable: false
                }
            ],
            products: [],
            editedIndex: -1,
            editedItem: {
                id: "",
                title: "",
                price: "",
                product_code: "",
                category: "",
                sub_category: "",
                product_type: "",
                company: "",
                description: "",
                selectedColor: [],
                selectedSize: [],
                selectedTag: []
            },
            defaultItem: {
                id: "",
                title: "",
                price: "",
                product_code: "",
                category: "",
                sub_category: "",
                product_type: "",
                company: "",
                description: "",
                selectedColor: [],
                selectedSize: [],
                selectedTag: []
            }
        };
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Product" : "Edit Product";
        },
        ...mapState({
            validRules: state => state.validation.validRules
        })
    },
    watch: {
        dialog(val) {
            val || this.close();
        }
    },

    created() {
        this.getProductSup();
    },
    mounted() {},
    methods: {
        addDialog() {
            this.productDialog = true;
            this.getProductSup();
        },
        getProductSup() {
            axios
                .get("/api/getProductSup", {})
                .then(res => {
                    this.category = res.data.category;
                    this.subCategory = res.data.subCategory;
                    this.company = res.data.company;
                    this.productType = res.data.productType;
                    (this.size = res.data.size), (this.color = res.data.color);
                })
                .catch(err => console.log(err.response));
        },

        editItem(item) {
            //getting tags of selected product
            axios
                .post("api/getProductTags", {
                    product_id: item.id
                })
                .then(res => {
                    this.enterSelectedTag = res.data;
                })
                .catch(err => console.log(err.response));

            this.editedIndex = this.products.data.indexOf(item);
            this.editedItem = Object.assign({}, item);
             
             this.selectedItem=item
            //these three done to get selected value during editing
            let col=[]
            let siz=[]
            for(let x of item.color){
                col.push(x.id)
            }
            for(let x of item.size){
                siz.push(x.id)
            }
            this.editedItem.selectedColor = col;
            this.editedItem.selectedSize = siz;
            this.enterSelectedTag = item.tag;

            this.productDialog = true;
        },

        deleteItem(item) {
            const index = this.products.indexOf(item);
            this.products.splice(index, 1);
            axios
                .delete("/api/products/" + item.id)
                .then(
                    (this.deleteDialog = false),
                    (this.dataUpdateMsg = "Course item deleted successfully"),
                    (this.dataUpdateAlert = true)
                );
        },

        close() {
            this.productDialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        save() {
            if (this.$refs.form.validate()) {
                if (this.editedIndex > -1) {
                    axios
                        .put("/api/products/" + this.editedItem.id, {
                            'title': this.editedItem.title,
                            'price': this.editedItem.price,
                            'code': this.editedItem.product_code,
                            'product_type_id': this.editedItem.product_type.id,
                            'category_id': this.editedItem.category.id,
                            'subCategory_id': this.editedItem.sub_category.id,
                            'company_id': this.editedItem.company.id,
                            'description': this.editedItem.description,
                            'color_name': JSON.stringify(this.editedItem.selectedColor),
                            'size': JSON.stringify(this.editedItem.selectedSize),
                            'tag_name': this.enterSelectedTag
                        })
                        .then(res => {
                            console.log('updated data:',res.data);
                            this.$refs.form.reset();
                            this.products.data.splice(this.products.data.indexOf(this.selectedItem),1,res.data)
                            this.close();
                            this.dataUpdateMsg ="Product item updated successfully";
                            this.dataUpdateAlert = true;
                
                        })
                        .catch(err => {
                            console.log(err.response);
                        });
                } else {
                   
                    axios
                        .post("/api/products", {
                            'title': this.editedItem.title,
                            'price': this.editedItem.price,
                            'code': this.editedItem.product_code,
                            'product_type_id': this.editedItem.product_type,
                            'category_id': this.editedItem.category,
                            'subCategory_id': this.editedItem.sub_category,
                            'company_id': this.editedItem.company,
                            'description': this.editedItem.description,
                            'color_name': this.editedItem.selectedColor,
                            'size': this.editedItem.selectedSize,
                            'tag_name': this.enterSelectedTag
                        })
                        .then(res => {
                            if (this.products.data.push(res.data)) {
                                this.close();
                                (this.dataUpdateMsg =
                                    "New Product Added successfully"),
                                (this.dataUpdateAlert = true);
                            }
                            this.$refs.form.reset();
                        })
                        .catch(err => {
                            if (err.response.data.errors.product_code) {
                                this.productCodeError =
                                    err.response.data.errors.product_code;
                                console.log(err.response.data.errors);
                            }
                            console.log(err.response);
                        });
                }
            }
        },
        onSecondaryUpload(e) {
            let file = e.target.files;

            for (var i = 0; i < file.length; i++) {
                var storageRef = firebase
                    .storage()
                    .ref("productImage/" + file[i].name); //prductImages is folder created in firebase in storage/files section
                this.uploadTask = storageRef.put(file[i]);

                this.uploadTask.on(
                    "state_changed",
                    function (snapshot) {},
                    error => {
                        //if 403 errors change rules in firebabse
                        //allow read, write: if request.auth == null;
                        //later authentication should be implemented this is just for testing
                        console.log(error);
                    },
                    () => {
                        this.uploadTask.snapshot.ref
                            .getDownloadURL()
                            .then(downloadURL => {
                                //here => has been used to get access with 'this' keyword
                                let img = downloadURL;
                                axios
                                    .post("api/imageUpload", {
                                        product_id: this.view.id,
                                        image: img
                                    })
                                    .then(res => {
                                        this.products.data.splice(this.products.data.indexOf(this.view),1,res.data)
                                        this.view = res.data
                                    })
                                    .catch(err => {
                                        (this.dataUpdateMsg =
                                            "Problem Uploading Images"),
                                        (this.dataUpdateAlert = true);
                                    });
                            });
                    }
                );
            }
            // axios.post('api/updateImage', {
            //     id: this.selectedItem.id
            // }).then(res => {
            //     this.selectedItem = res.data
            //     this.products.splice(this.selectedIndex, 1, res.data)
            // }).catch(err => console.log(err.response))

            //multiple file upload work on simple database
            // let file = e.target.files

            // for (var i = 0; i < file.length; i++) {
            //     let data = new FormData();
            //     data.append("selectedFile", file[i]);
            //     data.append("id", this.selectedItem.id);
            //     let settings = {
            //         headers: {
            //             "content-type": "multipart/form-data"
            //         }
            //     };
            //     axios
            //         .post("api/imageUpload", data, settings)
            //         .then(res => {})
            //         .catch(err => {
            //             (this.dataUpdateMsg = "Problem Uploading Images"),
            //             (this.dataUpdateAlert = true);
            //         });
            // }
            // axios.post('api/updateImage', {
            //     id: this.selectedItem.id
            // }).then(res => {
            //     this.selectedItem = res.data
            //     this.products.splice(this.selectedIndex, 1, res.data)
            // }).catch(err => console.log(err.response))
        },
        showImages(item) {
            this.view = item
            this.imageViewDialog = true;
        },
        viewProduct(item) {
            this.view = item;
            this.productViewDialog = true;
        },
        getImage(view) {
            return view.image;
        },
        getSecImage(item){
            return item.image
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
        onSecondaryClick() {
            this.isSecondarySelecting = true;
            window.addEventListener(
                "focus",
                () => {
                    this.isSecondarySelecting = false;
                }, {
                    once: true
                }
            );

            this.$refs.secondaryUploader.click();
        },
        onFileChanged(e) {
            let file = e.target.files[0];
            console.log(file.name);
            var storageRef = firebase
                .storage()
                .ref("productImage/" + file.name); //prductImages is folder created in firebase in storage/files section
            this.uploadTask = storageRef.put(file);
            this.addPrimaryImage();
            //working on simple database upload
            // const file = e.target.files[0];
            // this.selectedFile = e.target.files[0];
            // this.addPrimaryImage();
        },
        addPrimaryImage() {
            this.uploadTask.on(
                "state_changed",
                function (snapshot) {},
                error => {
                    //if 403 errors change rules in firebabse
                    //allow read, write: if request.auth == null;
                    //later authentication should be implemented this is just for testing
                    console.log(error);
                },
                () => {
                    this.uploadTask.snapshot.ref
                        .getDownloadURL()
                        .then(downloadURL => {
                            //here => has been used to get access with 'this' keyword
                            let image = downloadURL;
                            axios
                                .post("api/addPrimaryImage", {
                                    'product_id': this.view.id,
                                    'file': image
                                })
                                .then(res => {
                                    this.products.data.splice(this.products.data.indexOf(this.view),1,res.data)
                                    this.view = res.data
                                })
                                .catch(err => {
                                    console.log(err.response);
                                });
                        });
                }
            );
            //working on simple database upload
            // let data = new FormData();
            // data.append(
            //     "selectedFile",
            //     this.selectedFile,
            //     this.selectedFile.name
            // );
            // data.append("id", this.selectedItem.id);
            // let settings = {
            //     headers: {
            //         "content-type": "multipart/form-data"
            //     }
            // };
            // axios
            //     .post("api/addPrimaryImage", data, settings)
            //     .then(res => {
            //         this.selectedItem = res.data
            //         this.products.splice(this.selectedIndex, 1, res.data)
            //     })
            //     .catch(err => {
            //         console.log(err.response);
            //     });
        },
        onPrimaryChange(e){
            let file = e.target.files[0];
            //deletes the file
            var refImage = firebase.storage().refFromURL(this.view.image);
            refImage.delete().then(() => {
                // File deleted successfully
            }).catch((error) => {
                // Uh-oh, an error occurred!
            });

            var storageRef = firebase
                .storage()
                .ref("productImage/" + file.name); //prductImages is folder created in firebase in storage/files section
            this.uploadTask = storageRef.put(file);
            this.addPrimaryImage();
        },
        deleteSecImage(item){
            //deletes from database
            axios.post('api/deleteSecImage',{
                'secId':item.id
            }).then(res=>{
                //delete from fetched data
                this.view.photo.splice(this.view.photo.indexOf(item),1)

                //delete from firebase
                var refImage = firebase.storage().refFromURL(item.image);
                refImage.delete()
            }).catch(err=>console.log(err.response))

        },
        enterTag() {
            this.enterSelectedTag.push(this.selectTag);
            this.selectTag = "";
        },
        removeTag(item) {
            this.enterSelectedTag.splice(
                this.enterSelectedTag.indexOf(item),
                1
            );
        },
        changeProductStatus(item) {
            this.selectedProduct = item;
            this.confirmStatusChangeDialog = true;
        },
        confirmProductStatusChange() {
            if (this.$refs.form.validate()) {
                axios
                    .post("api/changeProductStatus", {
                        product_id: this.selectedProduct.id,
                        status: this.product_status
                    })
                    .then(res => {
                        this.products.splice(
                            this.products.indexOf(this.selectedProduct),
                            1,
                            res.data
                        );
                        this.confirmStatusChangeDialog = false;
                    })
                    .catch(err => console.log(err.response));
            }
        },
        paginate($event) {
            axios
                .post("/api/myProducts?page=" + $event.page, {
                    'per_page': $event.itemsPerPage
                }) //see the response to understand this-page urls
                .then(res => {
                    this.products = res.data;
                    this.loading = false
                })
                .catch(err => console.log(err.response));
        }
    }
};
</script>
