<template>
<div>
    <v-dialog v-model="setDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
        <template v-slot:activator="{ on:setDialog,attrs }">
            <v-tooltip top>
                <template v-slot:activator="{ on:tooltip }">
                    <v-btn class="mr-2 float-right" fab dark color="main" v-bind="attrs" v-on="{...setDialog,...tooltip}">
                        <v-icon dark>mdi-plus</v-icon>
                    </v-btn>
                </template>
                <span>Add Question</span>
            </v-tooltip>
        </template>
        <v-card>
            <v-toolbar dark color="primary" dense>
                <v-btn icon dark @click="setDialog = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-toolbar-title>Add question to MCQ title</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn dark text>Save</v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-data-table :headers="headers" :items="questions" class="elevation-1">
                            <template v-slot:top>
                                <v-container>
                                    <v-row>
                                        <v-col cols="2">
                                            <v-select v-model="subject_id" @change="getChapter" :items="subjects" label="Select Subject" item-text="subject_name" item-value="id"></v-select>

                                        </v-col>
                                        <v-col cols="2">
                                            <v-select v-model="chapter_id" @change="getQuestion" :items="chapters" label="Select Chapter" item-text="chapter_name" item-value="id"></v-select>

                                        </v-col>
                                    </v-row>
                                </v-container>

                                <v-toolbar-title class="ml-5">List of Question</v-toolbar-title>
                            </template>
                            <v-divider></v-divider>

                            <template v-slot:item.actions="{ item }">
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-icon small class="mr-2" @click="saveToSet(item)" v-bind="attrs" v-on="on">
                                                mdi-plus
                                            </v-icon>
                                        </template>
                                        <span>Add question</span>
                                    </v-tooltip>

                            </template>
                            <template v-slot:no-data>
                                <p>Select chapter to see questions</p>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>

</div>
</template>

<script>
export default {
    data() {
        return {
            setDialog: false,
            subjects: [],
            subject_id: 0,
            chapter_id: 0,
            chapters: [],
            questions: [],
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Question',
                    value: 'question'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            try:[]
        }
    },
    mounted() {
        axios.get('/api/course/subject', {
            params: {
                id: this.course_id
            }
        }).
        then(res => this.subjects = res.data.mbbs_subjects)
            .catch(err => console.log(err.response))


    },
    computed: {
        course_id() {
            return this.$route.params.course_id
        },
        set_name() {
            return this.$route.params.set_name
        },
        set_id() {
            return this.$route.params.set_id
        }

    },
    methods: {
        getChapter() {
            axios.get('/api/course/subjects/chapter', {
                params: {
                    id: this.subject_id
                }
            }).
            then(res => this.chapters = res.data.chapters)
                .catch(err => console.log(err.response))
        },
        getQuestion() {
            axios.get('/api/course/subject/chapters/question', {
                params: {
                    id: this.chapter_id
                }
            }).
            then(res => this.questions = res.data.questions)
                .catch(err => console.log(err.response))
        },
        saveToSet(item) {
            axios.post('/api/setCreate', {
                    'set_id': this.set_id,
                    'selected': item.id,
                })
                .then(res => console.log('added')).catch(err => {
                    console.log(err.response)
                })
        },
        
    }
}
</script>
