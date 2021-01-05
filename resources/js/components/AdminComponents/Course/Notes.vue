<template>
<div>
    <v-card flat>
        <v-data-table :headers="note_headers" :items="notes" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>

                    <v-dialog v-model="note_dialog" persistent max-width="1000px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn color="primary" dark v-bind="attrs" v-on="on">
                                Create note
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">Create your note here</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container fluid>
                                    editor needed
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="note_dialog=false">Close</v-btn>
                                <v-btn color="blue darken-1" text @click="saveNote">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>

            <template v-slot:item.actions="{ item }">

                <v-dialog v-model="noteViewDialog" width="900px">
                    <template v-slot:activator="{ on, attrs }">

                        <v-icon small class="mr-2" v-bind="attrs" v-on="on">
                            mdi-eye
                        </v-icon>

                    </template>
                    <v-card>
                        <div v-html="item.note" class="pa-5"></div>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="noteViewDialog = false">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-icon small class="mr-2" @click="editNoteItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon small @click="deleteNoteItem(item)">
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
        </v-data-table>
    </v-card>
</div>
</template>

<script>


export default {
    
    data() {
        return {
            note_dialog: false,
            noteViewDialog: false,
            notes: [],
            note_headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Chapter',
                    value: 'chapter.chapter_name'
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
            editedNoteItem: {
                note: ""
            },
            editedNoteIndex: -1,
            defaultNoteItem: {
                note: ''
            },
        }
    },
    computed: {
        chapter_id() {
            return this.$route.params.chapter_id; //returns value set in route params
        },
    },
    watch: {
        dialog(val) {
            val || this.close();
        }
    },
    created() {
        this.initialize();
    },
    methods: {
        initialize() {
            this.notes = [];
            axios.interceptors.request.use(
                config => {
                    this.loading = true;
                    return config;
                },
                error => {
                    this.loading = false;
                    return Promise.reject(error);
                }
            );

            axios.interceptors.response.use(
                response => {
                    this.loading = false;
                    return response;
                },
                error => {
                    this.loading = false;
                    return Promise.reject(error);
                }
            );

            //Getting notes
            axios
                .get("/api/course/subject/chapters/note", {
                    params: {
                        id: this.chapter_id
                    }
                })
                .then(res => this.notes = res.data.notes)
                .catch(err => console.log(err.response));
        },
        editNoteItem(item) {
            this.editedNoteIndex = this.notes.indexOf(item);
            this.editedNoteItem = Object.assign({}, item);
            this.note_dialog = true;
        },
        deleteNoteItem(item) {
            const index = this.notes.indexOf(item)
            confirm('Are you sure you want to delete this item?') && this.notes.splice(index, 1)
            axios.delete('/api/course/subject/chapters/note/' + item.id)
                .then(res => console.log('use snack bar and alert'))
        },
        closeNoteDialog() {
            this.note_dialog = false;
            this.$nextTick(() => {
                this.editedNoteItem = Object.assign({}, this.defaultNoteItem);
                this.editedNoteIndex = -1;
            });
        },
        goToView(id) {
            this.noteViewDialog = true
        },
        saveNote() {
            if (this.editedNoteIndex > -1) {
                axios
                    .put("/api/course/subject/chapters/note/" + this.editedNoteItem.id, {
                        note: this.editedNoteItem.note,
                        chapter_id: this.chapter_id
                    })
                    .then(res =>
                        Object.assign(
                            this.notes[this.editedNoteIndex],
                            res.data.notes
                        )
                    )
                    .catch(err => console.log(err.response));
                Object.assign(this.notes[this.editedNoteIndex], this.editedNoteItem);
            } else {
                axios
                    .post("/api/course/subject/chapters/note", {
                        note: this.editedNoteItem.note,
                        chapter_id: this.chapter_id
                    })
                    .then(res => this.notes.push(res.data.notes))
                    .catch(err => console.dir(err.response));
            }
            this.closeNoteDialog();
        },
    }

}
</script>
