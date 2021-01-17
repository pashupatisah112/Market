<template>
<v-container fluid>

    <!--heading-->
    <v-row class="mt-5" justify="center">
        <p class="headline text-lg-center font-weight-bold">Courses</p>
    </v-row>
    <!--end heading-->

    <!--course list-->
    <v-data-table :headers="headers" :items="courses" sort-by="calories" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                    <v-card-actions>
                        <v-icon x-large color="white">mdi-account-star</v-icon>
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>courses Management</v-toolbar-title>
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
                                        <v-text-field v-model="editedItem.course_name" label="Course Name" :rules="courseRules" :error-messages="errCourse" required></v-text-field>
                                        <v-textarea v-model="editedItem.description" label="Short Description" :auto-grow="true" :clearable="true" :rows="1"></v-textarea>
                                        editor needed for detail
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

export default {
    
    data() {
        return {
            role_id: null,
            iconDialog: false,
            changeIconDialog: false,
            selectedFile: null,
            isSelecting: false,
            url: null,
            alertColor: 'success',
            timeout: 2000,
            dataUpdateMsg: '',
            dataUpdateAlert: false,
            deleteDialog: false,
            errors: [],
            errCourse: '',
            courseRules: [
                v => !!v || 'Role Name is required',
                v => v.length <= 15 || "Max 15 characters",
            ],
            details: [],
            dialog: false,
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Course Name',
                    value: 'course_name'
                },
                {
                    text: 'Description',
                    value: 'description'
                },
                {
                    text: 'Details',
                    value: 'detail'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            courses: [],
            editedIndex: -1,
            editedItem: {
                id: '',
                course_name: '',
                description: '',
                detail: '',
                icon: '',
            },
            defaultItem: {
                id: '',
                course_name: '',
                description: '',
                details: '',
                icon: '',
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
        axios.get('/api/getCurrentUser', {}).
        then(res => this.role_id = res.data.auth_user[0].role_id)
            .catch(err => console.log(err.response))

    },
    methods: {
        initialize() {
            this.courses = []
            axios.get('/api/courses', {}).
            then(res => this.courses = res.data.courses)
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.courses.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.courses.indexOf(item)
            this.courses.splice(index, 1)
            axios.delete('/api/courses/' + item.id)
                .then(this.deleteDialog = false,
                    this.dataUpdateMsg = 'Course item deleted successfully',
                    this.dataUpdateAlert = true
                )
        },
        goTodetail(item) {
            if (this.role_id == 1) {
                this.$router.push({
                    name: 'admin.course.details',
                    params: {
                        id: item.id,
                        role_id: this.role_id,
                        course_name: item.course_name
                    }
                })
            } else if (this.role_id == 2) {
                this.$router.push({
                    name: 'staff.course.details',
                    params: {
                        id: item.id,
                        role_id: this.role_id,
                        course_name: item.course_name
                    }
                })
            }

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
                axios.put('/api/courses/' + this.editedItem.id, {
                        'course_name': this.editedItem.course_name,
                        'description': this.editedItem.description,
                        'detail': this.editedItem.detail
                    })
                    .then(res => {
                        if (Object.assign(this.courses[this.editedIndex], res.data.courses)) {
                            this.close()
                            this.dataUpdateMsg = 'Course item updated successfully'
                            this.dataUpdateAlert = true
                        }
                    })
                    .catch(err => {
                        if (err.response.status == 422) {
                            this.errCourse = err.response.data.errors.course_name
                        }
                    })
                Object.assign(this.courses[this.editedIndex], this.editedItem)
            } else {

                axios.post('/api/courses', {
                        'course_name': this.editedItem.course_name,
                        'description': this.editedItem.description,
                        'detail': this.editedItem.detail
                    })
                    .then(res => {
                        if (this.courses.push(res.data.courses)) {
                            this.close()
                            this.dataUpdateMsg = 'New Course Added successfully',
                                this.dataUpdateAlert = true
                        }
                    }).catch(err => {
                        if (err.response.status == 422) {
                            this.errCourse =
                                err.response.data.errors.course_name
                        }
                    })
            }
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
            axios.post('api/updateCourseIcon', data, settings)
                .then(res => {
                    this.courses.push(res.data.courses)
                }).catch(err => {
                    console.log(err.response)
                });

        },
        getCourseIcon(item) {
            return "../storage/" + item.icon
        }
    },

}
</script>
