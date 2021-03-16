<template>
<div>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <p class="caption mx-5" v-if="this.comments.length<1">{{$t('words.detail.noReviews')}}....</p>

                <div v-else>
                    <div v-for="item in comments" :key="item.id">

                        <v-list-item>
                            <v-list-item-avatar color="black">
                                <v-icon color="white">mdi-account-star</v-icon>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title class="font-weight-bolder">{{item.user.name}}</v-list-item-title>

                            </v-list-item-content>
                        </v-list-item>
                        <p class="mx-5 body-2">{{item.comment}}</p>
                        <p class="mx-8 body-2" v-if="item.reply">
                            <span class="font-weight-bold">Replied</span>
                            <v-icon class="mdi-flip-h">mdi-reply</v-icon>
                            {{item.reply}}
                        </p>
                        <v-divider></v-divider>
                    </div>
                </div>

                <v-row>
                    <v-form v-model="valid" ref="form" style="width:75%">
                        <v-textarea v-model="commentBox" rows="1" :rules="[validRules.required]" class="mx-5 mt-5 " rounded auto-grow dense full-width :placeholder="$t(placeAsk())" outlined></v-textarea>
                    </v-form>
                    <v-btn dark rounded @click="makeComment" class="mt-5">{{$t('words.detail.submit')}}</v-btn>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
import {
    mapState
} from 'vuex'
export default {
    data() {
        return {
            valid: true,
            comments: [],
            commentBox: '',
            product_code: this.$route.params.code
        }
    },
    computed: {
        ...mapState({
            validRules: state => state.validation.validRules,
            auth:state=>state.autentication.auth
        })
    },
    mounted() {
        this.getComents()
    },
    methods: {
        getComents() {
            axios.post('api/getComments', {
                code: this.product_code
            }).then(res => {
                this.comments = res.data
            }).catch(err => console.log(err.response))
        },
        makeComment() {
            if (this.$refs.form.validate()) {
                axios.post('api/makeComment', {
                    code: this.product_code,
                    comment: this.commentBox
                }).then(res => {
                    this.comments.push(res.data)
                    this.$refs.form.reset()
                    db.collection("notification").add({
                        user_name: this.auth.name,
                        type: 'comment',
                        created_at: new Date(),
                        read_at: null,
                    })
                }).catch(err => console.log(err.response))
            }
        },
        placeAsk(){
            return 'words.detail.ask'
        }
    }
}
</script>
