<template>
<v-container fluid>
    <!--heading-->
    <v-row justify="center">
        <p class="headline text-lg-center font-weight-bold">Exams</p>
    </v-row>
    <!--end heading-->

    <!--course list-->
    <v-data-table :headers="headers" :items="exams" sort-by="calories" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="main">
                    <v-card-actions>
                        <v-icon x-large color="white">mdi-account-star</v-icon>
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>Exams Management</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <!--add new course-->
                <v-dialog v-model="categoryDialog" max-width="500px">
                    <template v-slot:activator="{ on:categoryDialog,attrs }">
                        <v-tooltip top>
                            <template v-slot:activator="{ on:tooltip }">
                                <v-btn class="mr-2 float-right" fab dark color="main" v-bind="attrs" v-on="{...categoryDialog,...tooltip}">
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
                                        <v-text-field v-model="editedItem.exam_title" label="Exam Title" :rules="nameRules" :error-messages="errExamName" required></v-text-field>
                                        <v-select v-model="editedItem.course_id" :items="courses" label="Course" item-text="course_name" item-value="id"></v-select>

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
            <v-dialog v-model="categoryDeleteDialog" persistent max-width="400" :retain-focus="false">
                <!--retain-focus helps prevent from maximum exceeding error caused when two items are deleted continuously. this is a bug so add this props compulsarily-->
                <template v-slot:activator="{ on:dialog, attrs }">
                    <v-tooltip top>
                        <template v-slot:activator="{ on:tooltip }">
                            <v-icon small @click="categoryDeleteDialog = true" v-bind="attrs" v-on="{...dialog,...tooltip}">
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Delete</span>
                    </v-tooltip>
                </template>
                <v-card>
                    <v-card-title class="headline">Delete Confirmation</v-card-title>
                    <v-card-text>Are you sure you want to delete this Exam Category?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="categoryDeleteDialog = false">Cancel</v-btn>
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

</v-container>
</template>

<script>
export default {
    data() {
        return {
            errExamName: '',
            nameRules: [
                v => !!v || 'Exam Name is required',
                v => v.length <= 15 || "Max 15 characters",
            ],
            categoryDialog: false,
            categoryDeleteDialog: false,
            headers: [
                {
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Exam Name',
                    value: 'exam_title'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            exams: [],
            editedIndex: -1,
            editedItem: {
                id: '',
                exam_title: '',
                course_id:''
            },
            defaultItem: {
                id: '',
                exam_title: '',
                course_id:''
            },
            courses:''
        }
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Category' : 'Edit Category Name'
        },

    },
    watch: {
        dialog(val) {
            val || this.close()
        },
    },
    mounted(){
        axios.get('/api/courses', {}).
            then(res => this.courses = res.data.courses)
                .catch(err => console.log(err.response))
    },
    created() {
        this.initialize()
    },
    methods: {
        initialize() {
            this.exams = []
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
            axios.get('/api/examCategory', {}).
            then(res => this.exams = res.data.exams)
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.exams.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.categoryDialog = true
        },

        deleteItem(item) {
            const index = this.exams.indexOf(item)
            this.exams.splice(index, 1)
            axios.delete('/api/examCategory/' + item.id)
                .then(this.categoryDeleteDialog = false,
                    this.dataUpdateMsg = 'Exam Category deleted successfully',
                    this.dataUpdateAlert = true
                )
        },
        close() {
            this.categoryDialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save() {
            if (this.editedIndex > -1) {
                axios.put('/api/examCategory/' + this.editedItem.id, {
                        'exam_title': this.editedItem.exam_title,
                        'course_id':this.editItem.course_id
                    })
                    .then(res => {
                        Object.assign(this.exams[this.editedIndex], res.data.exams),
                        this.close(),
                        this.dataUpdateMsg = 'Exam Item updated successfully',
                        this.dataUpdateAlert = true

                    })
                    .catch(err => {
                        this.errExamName = err.response.data.errors.exam_title

                    })
                Object.assign(this.exams[this.editedIndex], this.editedItem)
            } else {
                axios.post('/api/examCategory', {
                        'exam_title': this.editedItem.exam_title,
                        'course_id':this.editItem.course_id
                    })
                    .then(res => {
                        this.exams.push(res.data.exams),
                        this.close(),
                        this.dataUpdateMsg = 'New Category Added successfully',
                            this.dataUpdateAlert = true

                    }).catch(err => {

                        this.errExamName =
                            err.response.data.errors.exam_title

                    })
            }
        },
    },

}
</script>
