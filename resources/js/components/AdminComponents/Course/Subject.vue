<template>
<div>
    <v-container fluid>
        <v-row>
            <v-icon color="black" @click="goBack">mdi-arrow-left-bold</v-icon>
        </v-row>
        <!--heading-->
        <v-row class="mt-5" justify="center">
            <p class="headline text-lg-center font-weight-bold">{{this.course_name}}</p>
        </v-row>
        <!--end heading-->

        <!--subject list-->
        <v-data-table :headers="headers" :items="subjects" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                        <v-card-actions>
                            <v-icon x-large color="white">mdi-account-star</v-icon>
                        </v-card-actions>
                    </v-card>
                    <v-toolbar-title>Subject Management</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <!--add new subject-->
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
                                            <v-text-field v-model="editedItem.subject_name" label="Subject Name" required></v-text-field>
                                            <p class="caption" style="color:red;margin-top:-15px">{{errors[0]}}</p>
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

                <!--view icon-->
                <v-tooltip top>
                    <template v-slot:activator="{ on:tooltip}">
                        <v-dialog v-model="iconDialog" width="300px" :retain-focus="false">
                            <template v-slot:activator="{ on:dialog}">
                                <v-icon small class="mr-2" v-on="{...tooltip,...dialog}">
                                    mdi-file-image
                                </v-icon>
                            </template>
                            <v-card>
                                <p class='subtitle-text text-center'>{{item.subject_name}} Icon</p>
                                <v-container>
                                    <v-row justify="center">
                                        <v-img v-if="item.icon" :src="getProfile(item)" style="width:50px;height:auto;"></v-img>
                                        <p v-else>No Icon</p>
                                    </v-row>

                                </v-container>

                                <v-card-actions>
                                    <v-btn text @click="iconDialog=false">Close</v-btn>
                                    <v-spacer></v-spacer>

                                    <!--Icon changing dialog-->
                                    <v-dialog v-model="changeIconDialog" max-width="350" :retain-focus="false" persistent>
                                        <template v-slot:activator="{on,attrs}">
                                            <v-btn class="mt-n5" text color="primary" :loading="isSelecting" @click="onButtonClick" v-bind="attrs" v-on="on">
                                                Update
                                            </v-btn>
                                            <input ref="uploader" class="d-none" type="file" accept="image/*" @change="onFileChanged">
                                        </template>
                                        <v-card>
                                            <v-card-title class="headline text-center">Updating Icon</v-card-title>

                                            <div class="profile mx-auto pa-1">
                                                <v-img :src="url" style="width:50px;height:auto;"></v-img>
                                            </div>

                                            <v-card-actions>

                                                <v-btn color="green darken-1" text @click="changeIconDialog = false">
                                                    cancel
                                                </v-btn>
                                                <v-spacer></v-spacer>
                                                <v-btn color="green darken-1" text @click="updateIcon(item)">
                                                    Confirm
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <!--End Icon change dialog-->

                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </template>
                    <span>View Icon</span>
                </v-tooltip>

                <!--end view icon-->

                <!--view button-->
                <v-tooltip top>
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon small class="mr-2" v-bind="attrs" v-on="on" @click="getChapters(item)">
                            mdi-eye
                        </v-icon>
                    </template>
                    <span>View Chapters</span>
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
                        <v-card-text>Are you sure you want to delete this Subject?</v-card-text>
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
        <!--end subject list-->

    </v-container>

</div>
</template>

<script>
export default {
    data: () => ({
        iconDialog: false,
        changeIconDialog: false,
        selectedFile: null,
        isSelecting: false,
        url: null,
        dialog: false,
        deleteDialog: false,
        errors: [],
        subjectRules: [
            v => !!v || 'Subject Name is required',
        ],
        headers: [{
                text: '#',
                align: 'start',
                sortable: false,
                value: 'id',
            },
            {
                text: 'Subject Name',
                value: 'subject_name'
            },
            {
                text: 'Created at',
                value: 'created_at'
            },
            {
                text: 'Updated at',
                value: 'updated_at'
            },
            {
                text: 'Actions',
                value: 'actions',
                sortable: false
            },
        ],
        subjects: [],
        editedIndex: -1,
        editedItem: {
            id: '',
            subject_name: '',
            created_at: '',
            updated_at: ''
        },
        defaultItem: {
            subject_name: '',
        },
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Subject' : 'Edit Subject'
        },
        course_id() {
            return this.$route.params.id //returns value set in route params
        },
        course_name() {
            return this.$route.params.course_name
        },
        role_id() {
            return this.$route.params.role_id
        }
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

            this.subjects = []
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
            axios.get('/api/course/subject', {
                params: {
                    id: this.course_id
                }
            }).
            then(res =>
                    this.subjects = res.data.mbbs_subjects
                )
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.courses.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.courses.indexOf(item)
            confirm('Are you sure you want to delete this item?') && this.courses.splice(index, 1)
            axios.delete('/api/courses/' + item.id)
                .then(res => this.snackbar = true)
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
                axios.put('/api/courses/' + this.editedItem.id, {
                        'course_name': this.editedItem.subject_name
                    })
                    .then(res => Object.assign(this.subjects[this.editedIndex], res.data.courses))
                    .catch(err => console.log(err.response))
                Object.assign(this.subjects[this.editedIndex], this.editedItem)
            } else {
                axios.post('/api/course/subject', {
                        'subject_name': this.editedItem.subject_name,
                        'course_id': 2
                    })
                    .then(res => this.subjects.push = res.data.subjects)
                    .catch(err => console.dir(err.response))
            }
            this.close()
        },
        getChapters(item) {
            if (this.role_id == 1) {
                this.$router.push({
                    name: 'admin.course.subject.chapter',
                    params: {
                        subject_id: item.id,
                        role_id: this.role_id,
                        subject_name: item.subject_name
                    }
                })
            } else if (this.role_id == 2) {
                this.$router.push({
                    name: 'staff.course.subject.chapter',
                    params: {
                        subject_id: item.id,
                        role_id: this.role_id,
                        subject_name: item.subject_name
                    }
                })
            }

        },
        goBack() {
            window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
        },
        onButtonClick() {
            this.isSelecting = true
            window.addEventListener('focus', () => {
                this.isSelecting = false
            }, {
                once: true
            })

            this.$refs.uploader.click()
        },
        onFileChanged(e) {
            console.log(e.target.files[0]);
            const file = e.target.files[0];
            this.selectedFile = e.target.files[0];
            this.url = URL.createObjectURL(file);
            this.changeIconDialog = true;
        },
        updateIcon(item) {
            this.changeIconDialog = false
            let data = new FormData()
            data.append('selectedFile', this.selectedFile, this.selectedFile.name)
            data.append('id', item.id)
            let settings = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            axios.post('api/updateSubjectIcon', data, settings)
                .then(res => {
                    this.subjects=res.data.subjects
                }).catch(err => {
                    console.log(err.response)
                });

        },
        getProfile(item) {
            return "../storage/" + item.icon;
        }
    },
};
</script>
