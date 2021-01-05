<template>
    <div>
        <v-row>
        <v-col cols="12" lg="2" md="3" sm="4" xs="6" v-for="card_item in card_items" :key="card_item.title">
            <v-card class="mx-auto" max-width="344" elevation="1">
                <v-list-item three-line>
                    <v-list-item-content>
                        <v-list-item-title class="headline mb-1">
                            {{card_item.value}}
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ card_item.title }}
                        </v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar>
                        <v-icon x-large color="success">{{
                                card_item.icon
                            }}</v-icon>
                    </v-list-item-avatar>
                </v-list-item>
            </v-card>
        </v-col>
    </v-row>
    </div>
</template>
<script>
export default {
    data(){
        return{
            card_items: [{
                title: "Courses",
                value: 0,
                icon: "mdi-table-of-contents"
            },
            {
                title: "Subjects",
                value: 0,
                icon: "mdi-book-open-page-variant"
            },
            {
                title: "Chapters",
                value: 0,
                icon: "mdi-clipboard-list"
            },
            {
                title: "Questions",
                value: 0,
                icon: "mdi-cloud-question"
            },
            {
                title: "Videos",
                value: 0,
                icon: "mdi-video"
            },
            {
                title: "Practice set",
                value: 0,
                icon: "mdi-view-split-horizontal"
            }
        ],
        }
    },
    mounted() {
        axios.get('/api/course/num', {})
            .then(res => Vue.set(this.card_items[0], 'value', res.data.course_num), ).catch(err => console.log(err.response))

        axios.get('/api/course/num', {})
            .then(res => Vue.set(this.card_items[1], 'value', res.data.subject_num), ).catch(err => console.log(err.response))

        axios.get('/api/course/num', {})
            .then(res => Vue.set(this.card_items[2], 'value', res.data.chapter_num), ).catch(err => console.log(err.response))

        axios.get('/api/course/num', {})
            .then(res => Vue.set(this.card_items[3], 'value', res.data.video_num), ).catch(err => console.log(err.response))

        axios.get('/api/course/num', {})
            .then(res => Vue.set(this.card_items[4], 'value', res.data.question_num), ).catch(err => console.log(err.response))

        axios.get('/api/course/num', {})
            .then(res => Vue.set(this.card_items[5], 'value', res.data.set_num), ).catch(err => console.log(err.response))
    },

}
</script>