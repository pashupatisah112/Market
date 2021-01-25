<template>
<v-container fluid>
    <!--course list-->
    <v-data-table :headers="headers" :items="products" class="elevation-1">
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
                                            <v-text-field v-model="editedItem.code" label="Product Code" dense :rules="[
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
                                                        editedItem.subCategory
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
                                            <v-select v-model="editedItem.type" :items="productType" label="Product Type" item-text="product_type" item-value="id" dense :rules="[
                                                        validRules.required
                                                    ]"></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-autocomplete v-model="
                                                        editedItem.selectedTag
                                                    " :items="tag" dense chips small-chips label="Select Tags" multiple item-value="id" item-text="tag_name" :rules="[
                                                        validRules.required
                                                    ]"></v-autocomplete>
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

    <!--snackbar for data update message-->
    <v-snackbar v-model="dataUpdateAlert" :color="alertColor" :timeout="timeout">
        <v-icon color="white" style="margin-right:10px">mdi-checkbox-marked-circle</v-icon>
        {{ dataUpdateMsg }}
        <v-btn color="white" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
    <!--end snackbar-->

    <!--product view dialog-->
    <!-- <v-dialog max-width="600" persistent v-model="productViewDialog">
        <v-card>
            <v-btn icon @click="productViewDialog=false" class="float-right">
                <v-icon>mdi-cancel</v-icon>
            </v-btn>

            <v-container fluid>
                <v-row>
                    <v-col cols="1">
                        <div style="width:50px; height:75px;margin-bottom:10px" v-for="item in view.photo" :key="item.id">
                            <v-img :src="getImage(item)"></v-img>
                        </div>

                    </v-col>
                    <v-col cols="5">
                        <v-img src="../images/sample.png"></v-img>
                    </v-col>
                    <v-col cols="6">
                        <v-row>
                            <v-col>
                                <p class="text-h5">{{view.title}}</p>
                                <h4>{{view.price}}</h4>
                                <p class="body-2" v-html="view.description"></p>
                                <div style="width:300px" class="mx-auto">
                                    <p class="float-left mr-7">Size</p>
                                    <v-select :items="items" label="Choose Size" dense outlined></v-select>
                                </div>
                                <div style="width:300px" class="mx-auto">
                                    <p class="float-left mr-6">Color</p>
                                    <v-select :items="items" label="Choose Color" dense outlined></v-select>
                                </div>
                                <div style="width:300px" class="mx-auto">
                                    <p class="float-left mr-5">Count</p>
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
                                </div>
                            </v-col>

                        </v-row>

                        <v-row justify="center" class="mt-8">
                            <v-btn class="text-capitalize white--text" color="blackTheme" rounded>Add to Cart</v-btn>
                        </v-row>

                        <v-row justify="center" class="mt-5">
                            <v-col cols="6">
                                <v-btn icon color="blackTheme">
                                    <v-icon>mdi-cards-heart</v-icon>
                                </v-btn>
                                <v-btn icon color="blackTheme">
                                    <v-icon>mdi-facebook</v-icon>
                                </v-btn>
                                <v-btn icon color="blackTheme">
                                    <v-icon>mdi-twitter</v-icon>
                                </v-btn>
                                <v-btn icon color="blackTheme">
                                    <v-icon>mdi-instagram</v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog> -->
    <!--end product view dialog-->

    <!--image view button-->
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
                    <v-col cols="4" align="center">
                        <v-img :src="getImage(selectedItem)" alt="Primary img"></v-img>
                        <div>
                            <div v-if="selectedItem.image==null">
                                <v-btn icon outlined x-large @click="onButtonClick" :loading="isSelecting" class="mt-2">
                                    <v-icon>mdi-image-plus</v-icon>
                                </v-btn>
                                <input ref="uploader" class="d-none" type="file" accept="image/*" @change="onFileChanged" />
                                <p>Add primary image</p>
                            </div>
                            <div v-else>
                                <v-btn icon outlined x-large class="mt-2" @click="onButtonClick" :loading="isSelecting">
                                    <v-icon>mdi-image-plus</v-icon>
                                </v-btn>
                                <input ref="uploader" class="d-none" type="file" accept="image/*" @change="onFileChanged" />
                                <p>Change primary image</p>
                            </div>
                        </div>
                    </v-col>

                    <v-divider class="my-2" vertical></v-divider>

                    <v-col cols="7" align="center">
                        <v-row>
                            <v-col v-for="img in selectedItem.photo" :key="img.id">
                                <div style="width:125px;height:auto">
                                    <v-img :src="getImage(img)" alt="sec img"></v-img>
                                </div>
                            </v-col>
                        </v-row>

                        <v-row justify="center">
                            <div class="mx-auto">
                                <v-btn icon outlined x-large @click="onSecondaryClick" :loading="isSecondarySelecting">
                                    <v-icon>mdi-image-plus</v-icon>
                                </v-btn>
                                <input ref="secondaryUploader" class="d-none" multiple type="file" accept="image/*" @change="onSecondaryUpload" />
                                <p>Add secondary images</p>
                            </div>
                        </v-row>

                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
    <!--end image view button-->
</v-container>
</template>

<script>
import VueFroala from "vue-froala-wysiwyg";
import {
    mapState
} from "vuex";
export default {
    data() {
        return {
            view: [],
            productViewDialog: false,
            imageViewDialog: false,

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
            selectedFile: [],
            primary: null,
            secondary: null,
            isSelecting: false,
            isSecondarySelecting:false,
            selectedItem: {
                title: ''
            },
            selectedIndex:null,

            alertColor: "success",
            timeout: 2000,
            dataUpdateMsg: "",
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
                code:'',
                category: "",
                subCategory: "",
                type: "",
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
                code:'',
                category: "",
                subCategory: "",
                type: "",
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
        this.initialize();
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
                    (this.size = res.data.size),
                    (this.color = res.data.color),
                    (this.tag = res.data.tag);
                })
                .catch(err => console.log(err.response));
        },
        initialize() {
            axios
                .get("/api/products", {})
                .then(res => {
                    this.products = res.data;
                    console.log(res.data);
                })
                .catch(err => console.log(err.response));
        },

        editItem(item) {
            this.editedIndex = this.products.indexOf(item);
            this.editedItem = Object.assign({}, item);
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
                            title: this.editedItem.title,
                            price: this.editedItem.price,
                            code:this.editedItem.code,
                            product_type_id: this.editedItem.type,
                            category_id: this.editedItem.category,
                            subCategory_id: this.editedItem.subCategory,
                            company_id: this.editedItem.company,
                            description: this.editedItem.description,
                            color_name: this.editedItem.selectedColor,
                            size: this.editedItem.selectedSize,
                            tag_name: this.editItem.selectedTag
                        })
                        .then(res => {
                            if (
                                Object.assign(
                                    this.products[this.editedIndex],
                                    res.data
                                )
                            ) {
                                this.close();
                                this.dataUpdateMsg =
                                    "Product item updated successfully";
                                this.dataUpdateAlert = true;
                            }
                        })
                        .catch(err => {
                            console.log(err.response);
                        });
                    Object.assign(
                        this.products[this.editedIndex],
                        this.editedItem
                    );
                } else {
                    axios
                        .post("/api/products", {
                            title: this.editedItem.title,
                            price: this.editedItem.price,
                            code:this.editedItem.code,
                            product_type_id: this.editedItem.type,
                            category_id: this.editedItem.category,
                            subCategory_id: this.editedItem.subCategory,
                            company_id: this.editedItem.company,
                            description: this.editedItem.description,
                            color_name: this.editedItem.selectedColor,
                            size: this.editedItem.selectedSize,
                            tag_name: this.editedItem.selectedTag
                        })
                        .then(res => {
                            if (this.products.push(res.data)) {
                                this.close();
                                (this.dataUpdateMsg =
                                    "New Product Added successfully"),
                                (this.dataUpdateAlert = true);
                            }
                        })
                        .catch(err => {
                            console.log(err.response);
                        });
                }
                this.$refs.form.reset();
            }
        },
        onSecondaryUpload(e) {
            let file=e.target.files
            
            for (var i = 0; i < file.length; i++) {
                let data = new FormData();
                data.append("selectedFile", file[i]);
                data.append("id", this.selectedItem.id);
                let settings = {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                };
                axios
                    .post("api/imageUpload", data, settings)
                    .then(res => {
                    })
                    .catch(err => {
                        (this.dataUpdateMsg = "Problem Uploading Images"),
                        (this.dataUpdateAlert = true);
                    });
            }
            axios.post('api/updateImage',{
                id:this.selectedItem.id
            }).then(res=>{
                   this.selectedItem = res.data
                    this.products.splice(this.selectedIndex,1,res.data)
            }).catch(err=>console.log(err.response))

        },
        showImages(item) {
            this.selectedIndex=this.products.indexOf(item)
            this.selectedItem = item;
            this.imageViewDialog = true;

        },
        viewProduct(item) {
            this.view = item;
            this.productViewDialog = true;
        },
        getImage(selectedItem) {
            return "../storage/" + selectedItem.image;
        },
        getPrimary(primary) {
            return "../storage/" + primary.image;
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
            const file = e.target.files[0];
            this.selectedFile = e.target.files[0];
            this.addPrimaryImage();
        },
        addPrimaryImage() {
            let data = new FormData();
            data.append(
                "selectedFile",
                this.selectedFile,
                this.selectedFile.name
            );
            data.append("id", this.selectedItem.id);
            let settings = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            axios
                .post("api/addPrimaryImage", data, settings)
                .then(res => {
                    this.selectedItem = res.data
                    this.products.splice(this.selectedIndex,1,res.data)
                })
                .catch(err => {
                    console.log(err.response);
                });
        }
    }
};
</script>
