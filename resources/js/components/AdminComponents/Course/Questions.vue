<template>
<div>
    <v-data-table :headers="question_headers" :items="questions" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-spacer></v-spacer>
                <v-dialog v-model="question_dialog" max-width="500px">
                    <template v-slot:activator="{ on }">
                        <v-btn color="main" dark class="mb-2" v-on="on">Add new question</v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">
                                Add Questions
                            </span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-textarea v-model="editedQuestionItem.question" label="Type question here" :auto-grow="true" :clearable="true" :rows="1"></v-textarea>
                                </v-row>
                                <v-row>
                                    <v-col cols=3>
                                        <v-text-field v-model="editedQuestionItem.option_1" label="Option A"></v-text-field>
                                    </v-col>
                                    <v-col cols=3>
                                        <v-text-field v-model="editedQuestionItem.option_2" label="Option B"></v-text-field>
                                    </v-col>
                                    <v-col cols=3>
                                        <v-text-field v-model="editedQuestionItem.option_3" label="Option C"></v-text-field>
                                    </v-col>
                                    <v-col cols=3>
                                        <v-text-field v-model="editedQuestionItem.option_4" label="Option D"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols=6>
                                        <v-text-field v-model="editedQuestionItem.answer" label="Answer"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols=12>
                                        <v-textarea v-model="editedQuestionItem.solution" label="Type question here" :auto-grow="true" :clearable="true" :rows="1"></v-textarea>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="question_dialog=false">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="saveQuestion">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">

            <v-dialog v-model="questionViewDialog" width="80%" style="width:80%;padding:20px;">
                <template v-slot:activator="{ on, attrs }">

                    <v-icon small class="mr-2" v-bind="attrs" v-on="on">
                        mdi-eye
                    </v-icon>

                </template>
                <v-card class="pad">
                    <v-row>
                        Q: {{item.question}}
                    </v-row>
                    <v-row>
                        <v-col cols="3">A) {{item.option_1}}</v-col>
                        <v-col cols="3">B) {{item.option_2}}</v-col>
                        <v-col cols="3">C) {{item.option_3}}</v-col>
                        <v-col cols="3">D) {{item.option_4}}</v-col>
                    </v-row>
                    <v-row>
                        Ans: {{item.answer}}
                    </v-row>
                    <v-row>
                        Solution: {{item.solution}}
                    </v-row>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="questionViewDialog = false">Close</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-icon small class="mr-2" @click="editQuestionItem(item)">
                mdi-pencil
            </v-icon>
            <v-icon small @click="deleteQuestionItem(item)">
                mdi-delete
            </v-icon>
        </template>
        <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
    </v-data-table>
</div>
</template>

<script>
export default {
    data() {
        return {
            question_dialog: false,
            questionViewDialog: false,
            questions: [],
            question_headers: [{
                    text: '#',
                    value: 'id'
                },
                {
                    text: 'Question',
                    value: 'question'
                },
                {
                    text: 'Option A',
                    value: 'option_1'
                },
                {
                    text: 'Option B',
                    value: 'option_2'
                },
                {
                    text: 'Option C',
                    value: 'option_3'
                },
                {
                    text: 'Option D',
                    value: 'option_4'
                },
                {
                    text: 'Answer',
                    value: 'answer'
                },
                {
                    text: 'Solution',
                    value: 'solution'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],

            editedQuestionIndex: -1,

            editedQuestionItem: {
                question: '',
                option_1: '',
                option_2: '',
                option_3: '',
                option_4: '',
                answer: '',
                solution: '',
            },

            defaultQuestionItem: {
                question: '',
                option_1: '',
                option_2: '',
                option_3: '',
                option_4: '',
                answer: '',
                solution: '',
            }
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
            this.questions = [];
            axios
                .get("/api/course/subject/chapters/question", {
                    params: {
                        id: this.chapter_id
                    }
                })
                .then(res => (this.questions = res.data.questions))
                .catch(err => console.log(err.response));
        },

        
        
        
        editQuestionItem(item) {
            this.editedQuestionIndex = this.questions.indexOf(item);
            this.editedQuestionItem = Object.assign({}, item);
            this.question_dialog = true;
        },
        deleteQuestionItem(item) {
            const index = this.questions.indexOf(item)
            confirm('Are you sure you want to delete this item?') && this.questions.splice(index, 1)
            axios.delete('/api/course/subject/chapters/question/' + item.id)
                .then(res => console.log('use snack bar and alert'))
        },
        closeQuestionDialog() {
            this.question_dialog = false;
            this.$nextTick(() => {
                this.editedQuestionItem = Object.assign({}, this.defaultQuestionItem);
                this.editedQuestionIndex = -1;
            });
        },
        
       
        
        saveQuestion() {
            if (this.editedQuestionIndex > -1) {
                axios
                    .put("/api/course/subject/chapters/question/" + this.editedQuestionItem.id, {
                        chapter_id: this.chapter_id,
                        question: this.editedQuestionItem.question,
                        option_1: this.editedQuestionItem.option_1,
                        option_2: this.editedQuestionItem.option_2,
                        option_3: this.editedQuestionItem.option_3,
                        option_4: this.editedQuestionItem.option_4,
                        answer: this.editedQuestionItem.answer,
                        solution: this.editedQuestionItem.solution,
                    })
                    .then(res =>
                        Object.assign(
                            this.questions[this.editedQuestionIndex],
                            res.data.questions
                        )
                    )
                    .catch(err => console.log(err.response));
                Object.assign(this.questions[this.editedQuestionIndex], this.editedQuestionItem);
            } else {
                axios
                    .post("/api/course/subject/chapters/question", {
                        chapter_id: this.chapter_id,
                        question: this.editedQuestionItem.question,
                        option_1: this.editedQuestionItem.option_1,
                        option_2: this.editedQuestionItem.option_2,
                        option_3: this.editedQuestionItem.option_3,
                        option_4: this.editedQuestionItem.option_4,
                        answer: this.editedQuestionItem.answer,
                        solution: this.editedQuestionItem.solution,
                    })
                    .then(res => this.questions.push(res.data.questions))
                    .catch(err => console.dir(err.response));
            }
            this.closeQuestionDialog();
        },
    }
}
</script>
