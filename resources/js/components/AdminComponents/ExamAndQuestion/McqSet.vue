<template>
<v-container fluid>
    <!--heading-->
    <v-row justify="center">
        <p class="headline text-lg-center font-weight-bold">MCQ sets</p>
    </v-row>
    <!--end heading-->

    <!--course list-->
    <v-data-table :headers="headers" :items="mcqs" sort-by="calories" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="main">
                    <v-card-actions>
                        <v-icon x-large color="white">mdi-account-star</v-icon>
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>MCQs Set Management</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <!--add new course-->
                <v-dialog v-model="mcqsDialog" max-width="500px">
                    <template v-slot:activator="{ on:mcqsDialog,attrs }">
                        <v-tooltip top>
                            <template v-slot:activator="{ on:tooltip }">
                                <v-btn class="mr-2 float-right" fab dark color="main" v-bind="attrs" v-on="{...mcqsDialog,...tooltip}">
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
                                        <v-text-field v-model="editedItem.title" label="Practice Set 1 or Past Question Set 1" :rules="nameRules" :error-messages="errExamLevel" required></v-text-field>
                                        <v-menu ref="menu" v-model="menu" :close-on-content-click="false" transition="scale-transition" offset-y min-width="290px">
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-text-field v-model="editedItem.year" label="Birthday date" readonly v-bind="attrs" v-on="on"></v-text-field>
                                            </template>
                                            <v-date-picker ref="picker" v-model="editedItem.year" :max="new Date().toISOString().substr(0, 10)" min="1950-01-01" @change="saveDate"></v-date-picker>
                                        </v-menu>
                                        <v-select v-model="editedItem.level_id" :items="levels" label="Exam Level" item-text="level_title" item-value="id"></v-select>
                                        <v-select v-model="editedItem.exam_id" :items="exams" label="Exam Category" item-text="exam_title" item-value="id"></v-select>
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

            <!--view button-->
                <v-tooltip top>
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon small class="mr-2" v-bind="attrs" v-on="on" @click="getQuestions(item)">
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
            <v-dialog v-model="mcqsDeleteDialog" persistent max-width="400" :retain-focus="false">
                <!--retain-focus helps prevent from maximum exceeding error caused when two items are deleted continuously. this is a bug so add this props compulsarily-->
                <template v-slot:activator="{ on:dialog, attrs }">
                    <v-tooltip top>
                        <template v-slot:activator="{ on:tooltip }">
                            <v-icon small @click="mcqsDeleteDialog = true" v-bind="attrs" v-on="{...dialog,...tooltip}">
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Delete</span>
                    </v-tooltip>
                </template>
                <v-card>
                    <v-card-title class="headline">Delete Confirmation</v-card-title>
                    <v-card-text>Are you sure you want to delete this Question Set?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="mcqsDeleteDialog = false">Cancel</v-btn>
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
            errExamLevel: '',
            levels: '',
            exams: '',
            courses: '',

            menu: false,
            modal: false,
            nameRules: [
                v => !!v || 'Exam Name is required',
                v => v.length <= 15 || "Max 15 characters",
            ],
            mcqsDialog: false,
            mcqsDeleteDialog: false,
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
                    text: 'Year',
                    value: 'year'
                },
                {
                    text: 'Level',
                    value: 'exam_level.level_title'
                },
                {
                    text: 'Exam',
                    value: 'exam_category.exam_title'
                },
                {
                    text: 'Course',
                    value: 'course.course_name'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            mcqs: [],
            editedIndex: -1,
            editedItem: {
                id: '',
                title: '',
                year: '',
                level_id: '',
                exam_id: '',
                course_id: ''
            },
            defaultItem: {
                id: '',
                title: '',
                year: '',
                level_id: '',
                exam_id: '',
                course_id: ''
            },
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
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
        },
    },
    mounted() {
        axios.get('/api/getLevels', {}).
        then(res => this.levels = res.data.levels)
            .catch(err => console.log(err.response))

        axios.get('/api/getExams', {}).
        then(res => this.exams = res.data.exams)
            .catch(err => console.log(err.response))

        axios.get('/api/courses', {}).
        then(res => this.courses = res.data.courses)
            .catch(err => console.log(err.response))
    },
    created() {
        this.initialize()
    },
    methods: {

        initialize() {
            this.mcqs = []
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
            axios.get('/api/mcqSet', {}).
            then(res => this.mcqs=res.data.mcqs)
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.mcqs.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.mcqsDialog = true
        },

        deleteItem(item) {
            const index = this.mcqs.indexOf(item)
            this.mcqs.splice(index, 1)
            axios.delete('/api/mcqSet/' + item.id)
                .then(this.mcqsDeleteDialog = false,
                    this.dataUpdateMsg = 'MCQ Set deleted successfully',
                    this.dataUpdateAlert = true
                )
        },
        close() {
            this.mcqsDialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save() {
            if (this.editedIndex > -1) {
                axios.put('/api/mcqSet/' + this.editedItem.id, {
                        'title': this.editedItem.title,
                        'year': this.editItem.year,
                        'level_id': this.editItem.level_id,
                        'exam_id': this.editedItem.exam_id,
                        'course_id': this.editedItem.course_id
                    })
                    .then(res => {
                        Object.assign(this.mcqs[this.editedIndex], res.data.mcqs),
                            this.close(),
                            this.dataUpdateMsg = 'MCQ set updated successfully',
                            this.dataUpdateAlert = true

                    })
                    .catch(err => {
                        this.errExamLevel = err.response.data.errors.title

                    })
                Object.assign(this.mcqs[this.editedIndex], this.editedItem)
            } else {
                axios.post('/api/mcqSet', {
                        'title': this.editedItem.title,
                        'year': this.editedItem.year,
                        'level_id': this.editedItem.level_id,
                        'exam_id': this.editedItem.exam_id,
                        'course_id': this.editedItem.course_id
                    })
                    .then(res => {
                        this.mcqs.push(res.data.mcqs),
                            this.close(),
                            this.dataUpdateMsg = 'MCQ set Added successfully',
                            this.dataUpdateAlert = true

                    }).catch(err => {

                        this.errExamLevel =
                            err.response.data.errors.title

                    })
            }
        },
        saveDate(date) {
            this.$refs.menu.save(date)
        },
        getQuestions(item){
            console.log(item.course_id)
            this.$router.push({
                    name: 'set.questions',
                    params: {
                        set_id:item.id,
                        course_id: item.course_id,
                        set_name:item.title
                    }
                })
        }
    },

}
</script>
