<template>
    <v-container fluid>
        <!--heading-->
        <v-row justify="center">
            <p class="headline text-lg-center font-weight-bold">
                All Questions from {{ this.set_name }}
            </p>
        </v-row>
        <!--end heading-->

        <!--course list-->
        <v-data-table
            :headers="headers"
            :items="sets"
            sort-by="calories"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-card class="px-3 py-3 mb-2 mr-2" color="main">
                        <v-card-actions>
                            <p class="white--text">{{ numQuestion }}</p>
                        </v-card-actions>
                    </v-card>
                    <v-toolbar-title>Question Set Management</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <!--add question dialog-->
                    <addQuestion></addQuestion>
                    <!--end add dialog question-->
                </v-toolbar>
            </template>
            <!--course item actions-->
            <template v-slot:item.actions="{ item }">
                <!--delete section-->
                <v-dialog
                    v-model="questionDeleteDialog"
                    persistent
                    max-width="400"
                    :retain-focus="false"
                >
                    <!--retain-focus helps prevent from maximum exceeding error caused when two items are deleted continuously. this is a bug so add this props compulsarily-->
                    <template v-slot:activator="{ on: dialog, attrs }">
                        <v-tooltip top>
                            <template v-slot:activator="{ on: tooltip }">
                                <v-icon
                                    small
                                    @click="questionDeleteDialog = true"
                                    v-bind="attrs"
                                    v-on="{ ...dialog, ...tooltip }"
                                >
                                    mdi-delete
                                </v-icon>
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                    <v-card>
                        <v-card-title class="headline"
                            >Delete Confirmation</v-card-title
                        >
                        <v-card-text
                            >Are you sure you want to delete this Question
                            Set?</v-card-text
                        >
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="green darken-1"
                                text
                                @click="questionDeleteDialog = false"
                                >Cancel</v-btn
                            >
                            <v-btn
                                color="green darken-1"
                                text
                                @click="deleteItem(item)"
                                >Confirm</v-btn
                            >
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
import AddQuestion from "./AddQuestions";
export default {
    components: { AddQuestion },
    data() {
        return {
            numQuestion: 0,
            subjects: "",
            chapters: "",
            questions: "",
            errSetName: "",
            questionDeleteDialog: false,
            headers: [
                {
                    text: "#",
                    align: "start",
                    sortable: false,
                    value: "id"
                },
                {
                    text: "Question",
                    value: "question"
                },
                {
                    text: "Chapter",
                    value: "chapter_id"
                },
                {
                    text: "Option 1",
                    value: "option_1"
                },
                {
                    text: "Option 2",
                    value: "option_2"
                },
                {
                    text: "Option 3",
                    value: "option_3"
                },
                {
                    text: "Option 4",
                    value: "option_4"
                },
                {
                    text: "Answer",
                    value: "answer"
                },
                {
                    text: "Solution",
                    value: "solution"
                },
                {
                    text: "Actions",
                    value: "actions",
                    sortable: false
                }
            ],
            sets: [],
        };
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? "New Category"
                : "Edit Category Name";
        },
        course_id() {
            return this.$route.params.course_id;
        },
        set_name() {
            return this.$route.params.set_name;
        },
        set_id() {
            return this.$route.params.set_id;
        }
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
            this.sets = [];
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
            axios
                .post("/api/getQuestionSet", {
                    id: this.set_id
                })
                .then(res => {
                    this.sets = res.data.sets[0].question;
                    this.numQuestion = res.data.sets[0].question.length;
                })
                .catch(err => console.log(err.response));
        },

        deleteItem(item) {
            const index = this.sets.indexOf(item);
            this.sets.splice(index, 1);
            axios
                .post("/api/removeFromSet", {
                    set_id: this.set_id,
                    selected: item.id
                })
                .then(res => {
                    this.sets = res.data.sets[0].question;
                    this.numQuestion = res.data.sets[0].question.length;
                })
                .catch(err => console.log(err.response));
                this.questionDeleteDialog=false;
        },
    }
};
</script>
