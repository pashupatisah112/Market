<template>
<div>
    <v-container fluid>
        <v-row>
            <div class="mt-n10">
                <v-breadcrumbs :items="breadItems"></v-breadcrumbs>
            </div>
        </v-row>
        <v-row>
            <p class="subtitle-text head-color">Homepage Contents</p>
        </v-row>
        <v-row>
            <v-col cols="12" lg="12">

                <!------------------------data-table for Carousel student quotes------------------------>
                <v-data-table :headers="headers" :items="thoughts" sort-by="calories" class="elevation-1">
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                                <v-card-actions>
                                    <v-icon x-large color="white">mdi-account-star</v-icon>
                                </v-card-actions>
                            </v-card>
                            <v-toolbar-title>thoughts Management</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-spacer></v-spacer>
                            <!--add new course-->
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
                                                    <v-text-field v-model="editedItem.course_name" label="Course Name" :rules="courseRules" required></v-text-field>
                                                    <p class="caption" style="color:red;margin-top:-15px">{{errors[0]}}</p>
                                                    <v-file-input v-model="editedItem.icon" @change="showChange" accept="image/*" label="File input"></v-file-input>
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
                <!---------------------end carousel table------------------------------->

            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            breadItems: [{
                    text: "Dashboard",
                    disabled: false,
                    href: "/#/admin/dashboard"
                },
                {
                    text: "Content",
                    disabled: false,
                    href: "/#/admin/content"
                },
                {
                    text: "Home Content",
                    disabled: true,
                    href: "/#/admin/content/home-content"
                }
            ],
            thought_dialog: false,
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Name',
                    value: 'full_name'
                },
                {
                    text: 'Post',
                    value: 'post'
                },
                {
                    text: 'Posted_At',
                    value: 'posted_at'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            thoughts: [],
            editedIndex: -1,
            editedItem: {
                course_name: '',
                icon: []
            },
            defaultItem: {
                course_name: '',
                icon: [],
            },
        }
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Course' : 'Edit Course'
        },

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
            this.thoughts = []
            axios.interceptors.request.use((config) => {
                this.loading = true;
                return config;
            }, (error) => {
                this.loading = false;
                return Promise.reject(error);
            });

            axios.interceptors.response.use((response) => {
                this.loading = false;
                return response;
            }, (error) => {
                this.loading = false;
                return Promise.reject(error);
            });
            axios.get('/api/thoughts', {}).
            then(res => this.thoughts = res.data.thoughts)
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.thoughts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.thoughts.indexOf(item)
            this.thoughts.splice(index, 1)
            axios.delete('/api/thoughts/' + item.id)
                .then(this.deleteDialog = false,
                    this.dataUpdateMsg = 'Course item deleted successfully',
                    this.dataUpdateAlert = true
                )
        },
        goTodetail(item) {
            this.$router.push({
                name: 'admin.course.details',
                params: {
                    id: item.id,
                    course_name:item.course_name
                }
            })
        },
        
        focusMessage(){
            this.errors=[]
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
                axios.put('/api/thoughts/' + this.editedItem.id, {
                        'course_name': this.editedItem.course_name,
                        //'icon':this.editedItem.icon
                    })
                    .then(res => {
                        if (Object.assign(this.thoughts[this.editedIndex], res.data.thoughts)) {
                            this.close()
                            this.dataUpdateMsg = 'Course item updated successfully'
                            this.dataUpdateAlert = true
                        }
                    })
                    .catch(err => {
                        if (err.response.status == 422) {
                            this.errors = err.response.data.errors.course_name
                        }
                    })
                Object.assign(this.thoughts[this.editedIndex], this.editedItem)
            } else {
                axios.post('/api/thoughts',{
                        'course_name': this.editedItem.course_name,
                        'icon':this.icon,
                    })
                    .then(res => {
                        console.log(this.icon.name)
                        if (this.thoughts.push(res.data.thoughts)) {
                            this.close()
                            this.dataUpdateMsg = 'New Course Added successfully',
                                this.dataUpdateAlert = true
                        }
                    }).catch(err => {
                        if (err.response.status == 422) {
                            this.errors = err.response.data.errors.course_name
                        }
                    })
            }
        },
    }
}
</script>
