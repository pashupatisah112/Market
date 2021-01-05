<template>
<v-container fluid style="width:100%">
    <v-row>
        <v-icon color="black" @click="goBack()">mdi-arrow-left-bold</v-icon>
    </v-row>
    <v-row class="mt-5" justify="center">
        <p class="headline text-lg-center font-weight-bold">{{this.subject_name}}</p>
    </v-row>
    <v-row>
        <v-data-table :headers="headers" :items="chapters" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                        <v-card-actions>
                            <v-icon x-large color="white">mdi-account-star</v-icon>
                        </v-card-actions>
                    </v-card>
                    <v-toolbar-title>Chapter Management</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on }">
                            <v-btn color="primary" dark class="mb-2" v-on="on">New Chapter</v-btn>
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
                                            <v-text-field v-model="
                                                        editedItem.chapter_name
                                                    " label="Chapter Name"></v-text-field>
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
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="goTodetail(item.id)">
                    mdi-eye
                </v-icon>
                <v-icon small class="mr-2" @click="editItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon small @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
        </v-data-table>
    </v-row>
</v-container>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        headers: [{
                text: '#',
                align: 'start',
                sortable: false,
                value: 'id',
            },
            {
                text: 'Chapter Name',
                value: 'chapter_name'
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
        chapters: [],
        editedIndex: -1,
        editedItem: {
            id: '',
            chapter_name: '',
            created_at: '',
            updated_at: ''
        },
        defaultItem: {
            chapter_name: '',
        },
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Chapter' : 'Edit Chapter'
        },
        subject_id() {
            return this.$route.params.subject_id //returns value set in route params
        },
        subject_name() {
            return this.$route.params.subject_name //returns value set in route params
        },
        role_id() {
            return this.$route.params.role_id //returns value set in route params
        }
    },
    mounted() {

        //returns value set in route params
    },
    watch: {
        dialog(val) {
            val || this.close()
        },
    },

    created() {
        this.initialize()
    },

    methods: {
        initialize() {
            this.chapters = []
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
            axios.get('/api/course/subjects/chapter', {
                params: {
                    id: this.subject_id
                }
            }).
            then(res => this.chapters = res.data.chapters)
                .catch(err => console.log(err.response))
        },

        editItem(item) {
            this.editedIndex = this.chapters.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.chapters.indexOf(item)
            confirm('Are you sure you want to delete this item?') && this.chapters.splice(index, 1)
            axios.delete('/api/courses/' + item.id)
                .then(res => this.snackbar = true)
        },
        goTodetail(id) {
            if (this.role_id == 1) {
                this.$router.push({
                    name: 'admin.course.subject.chapter.details',
                    params: {
                        chapter_id: id
                    }
                })
            } else if (this.role_id == 2) {
                this.$router.push({
                    name: 'staff.course.subject.chapter.details',
                    params: {
                        chapter_id: id
                    }
                })
            }

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
                        'course_name': this.editedItem.course_name
                    })
                    .then(res => Object.assign(this.courses[this.editedIndex], res.data.courses))
                    .catch(err => console.log(err.response))
                Object.assign(this.courses[this.editedIndex], this.editedItem)
            } else {
                axios.post('/api/course/subjects/chapter', {
                        'chapter_name': this.editedItem.chapter_name,
                        'subject_id': this.subject_id
                    })
                    .then(res => this.chapters.push(res.data.chapters))
                    .catch(err => console.dir(err.response))
            }
            this.close()
        },
        goBack() {
            window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
        }
    },
}
</script>

<style scoped>
.border {
    border-radius: 50px;
    background-color: green;
    padding: 10px;
}
</style>
