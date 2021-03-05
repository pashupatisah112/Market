<template>
<v-container fluid>
    <!--course list-->
    <v-data-table :headers="headers" :items="comments.data" sort-by="calories" class="elevation-1" :footer-props="{ itemsPerPageOptions: [5, 10, 15],itemsPerPageText:'Comments per page' }"
            :server-items-length="comments.total"
            :loading="loading"
            loading-text="Loading.....Please wait."
            @pagination="paginate">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-toolbar-title>Comments Management</v-toolbar-title>
            </v-toolbar>
        </template>
        <!--comments item actions-->
        <template v-slot:item.actions="{ item }">

            <!--edit button-->
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon small class="mr-2" @click="giveReply(item)" v-bind="attrs" v-on="on">
                        mdi-reply
                    </v-icon>
                </template>
                <span>Reply</span>
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
            <v-btn color="primary" @click="paginate">Reset</v-btn>
        </template>
    </v-data-table>
    <!--end course list-->

    <!--reply dialog-->
        <v-dialog v-model="replyDialog" persistent max-width="600">
                <v-card>
                    <v-card-title class="headline">Replying to....</v-card-title>
                    <v-card-text class="body-1">{{selectedComment.comment}}</v-card-text>
                    <v-form v-model="valid" ref="form">

                    </v-form>
                    <v-text-field v-model="reply" placeholder="Your reply here...." class="mx-5" dense :rules="[validRules.required]"></v-text-field>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="replyDialog = false">Cancel</v-btn>
                        <v-btn color="green darken-1" text @click="replyComment">Reply</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
    <!---end reply dialog-->

</v-container>
</template>

<script>
import {
    mapState
} from 'vuex'

export default {

    data() {
        return {
            loading:true,
            //form
            valid:true,
            
            reply:'',
            selectedComment:'',
            replyDialog:false,
            deleteDialog:false,

            //headers
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Product code',
                    value: 'product.product_code'
                },
                {
                    text: 'User',
                    value: 'user.name'
                },
                {
                    text: 'Comment',
                    value: 'comment'
                },
                {
                    text: 'Reply',
                    value: 'reply'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            comments: [],
        }
    },

    computed: {
        ...mapState({
            validRules: state => state.validation.validRules
        })

    },
    methods: {
        paginate($event){
            axios
                .post("/api/commentList?page="+$event.page, {'per_page':$event.itemsPerPage}) //see the response to understand this-page urls
                .then(res => {
                    this.comments = res.data;
                    this.loading=false
                })
                .catch(err => console.log(err.response));
        },
        giveReply(item){
            this.selectedComment=item
            this.replyDialog=true
        },
        replyComment(){
            if(this.$refs.form.validate()){
               axios.post('api/replyComment',{
                replyText:this.reply,
                comment_id:this.selectedComment.id
            }).then(res=>{
                this.comments.data.splice(this.comments.indexOf(this.selectedComment),1,res.data)
                this.selectedComment=''
                this.replyDialog=false
            }).catch(err=>console.log(err.response))
            }
            
        },
        deleteItem(item) {
            const index = this.comments.data.indexOf(item)
            this.comments.data.splice(index, 1)
            axios.post('/api/deleteComment/',{
                comment_id:item.id
            })
            .then(res=>{
                this.deleteDialog=false
              console.log(res.data)
            }).catch(err=>console.log(err.response))

        },
    },

}
</script>
