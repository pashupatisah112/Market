<template>
<div>
    <v-card flat>
        <v-data-table :headers="video_headers" :items="videos" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="video_dialog" persistent max-width="600px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn color="primary" dark v-bind="attrs" v-on="on">
                                Add video
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">Add your video</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>

                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="video_dialog=false">Close</v-btn>
                                <v-btn color="blue darken-1" text @click="saveVideo">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>

            <template v-slot:item.actions="{ item }">
                <v-dialog v-model="videoViewDialog" width="600px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon small class="mr-2" v-bind="attrs" v-on="on">
                            mdi-eye
                        </v-icon>
                    </template>
                    <v-card>
                        <div v-html="item.video"></div>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="videoViewDialog = false">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-icon small @click="deleteVideoItem(item)">
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
            video_dialog: false,
            videoViewDialog: false,
            videos: [],
            video_headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'video Ttle',
                    value: 'video'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],

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
            
            this.videos = [];
            //Getting videos
            axios
                .get("/api/course/subject/chapters/video", {
                    params: {
                        id: this.chapter_id
                    }
                })
                .then(res => (this.videos = res.data.videos))
                .catch(err => console.log(err.response));

        },
        saveVideo() {
            axios
                .post("/api/course/subject/chapters/video", {
                    note: this.editedVideoItem.video,
                    chapter_id: this.chapter_id
                })
                .then(res => this.videos.push(res.data.videos))
                .catch(err => console.dir(err.response));
            this.close();
        },
    }
}
</script>
