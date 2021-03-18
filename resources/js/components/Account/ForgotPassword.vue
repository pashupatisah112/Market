<template>
<div>
    <v-dialog v-model="forgotPasswordDialog" max-width="400" persistent>
        <v-card flat>
            <v-container>
                <v-btn small icon class="float-right mr-1 mt-n3" @click="unsetForgotPasswordDialog">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-row justify="center">
                    <p class="text-center m-2 font-weight-bold">{{$t('words.auth.resetPassword')}}</p>
                </v-row>

                <v-stepper v-model="e1">
                    <v-stepper-items>
                        <v-stepper-content step="1">

                            <p class="text-center font-weight-bold">{{$t('words.auth.enterEmail')}}</p>

                            <v-form v-model="valid" ref="form1">
                                <v-text-field rounded dense solo filled v-model="email" :placeholder="$t(placeEmail())" :rules="[validRules.required,validRules.email]" :error-messages="emailError"></v-text-field>
                                <v-btn rounded dark block @click="sendResetCode" :loading="loading" class="text-capitalize my-2">{{$t('words.auth.getCode')}}</v-btn>
                            </v-form>
                        </v-stepper-content>

                        <v-stepper-content step="2">
                            <p class="text-center font-weight-bold">{{$t('words.auth.verifyCode')}}</p>

                            <v-form v-model="valid" ref="form2">
                                <v-text-field rounded dense solo filled v-model="verifyingCode" :placeholder="$t(placeCode())" :rules="[validRules.required]" :error-messages="verificationError"></v-text-field>
                                <v-btn rounded dark block @click="confirmCode" class="text-capitalize my-2">{{$t('words.auth.submitCode')}}</v-btn>
                            </v-form>
                        </v-stepper-content>

                        <v-stepper-content step="3">
                            <p class="text-center font-weight-bold">{{$t('words.auth.resetPassword')}}</p>

                            <v-form v-model="valid" ref="form3">
                                <v-text-field :rules="[validRules.required,validRules.lengthMin8]" :placeholder="$t(placePassword())" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" @click:append="show1 = !show1" :type="show1 ? 'text' : 'password'" prepend-icon="mdi-lock" v-model="newPassword" rounded dense solo filled></v-text-field>
                                <v-text-field :rules="[validRules.required,rule.confirm]" :placeholder="$t(placeConfirmPassword())" :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'" @click:append="show2 = !show2" :type="show2 ? 'text' : 'password'" prepend-icon="mdi-lock" v-model="confirmNew" rounded dense solo filled></v-text-field>

                                <v-btn rounded dark block @click="changePassword" :loading="loading" class="text-capitalize my-2">{{$t('words.auth.confirmChange')}}</v-btn>
                            </v-form>
                        </v-stepper-content>
                    </v-stepper-items>
                </v-stepper>
            </v-container>

        </v-card>
    </v-dialog>
</div>
</template>

<script>
import {
    mapState,
    mapMutations
} from 'vuex'
export default {
    data() {
        return {
            e1: 1,
            valid: true,
            email: '',
            verifyingCode: '',
            verificationCode: '',
            verificationError:'',
            newPassword: '',
            confirmNew: '',
            rule: {
                confirm: v => this.newPassword == this.confirmNew || "Password must match",
            },
            show1:false,
            show2:false,
            loading:false,
            emailError:''

        }
    },
    computed: {
        ...mapState({
            forgotPasswordDialog: state => state.authentication.forgotPasswordDialog,
            validRules: state => state.validation.validRules
        })
    },
    methods: {
        ...mapMutations(['unsetForgotPasswordDialog']),
        sendResetCode() {
            if (this.$refs.form1.validate()) {
                this.loading=true
                this.generateCode()

                axios.post('api/sendPasswordResetCode', {
                    'code': this.verificationCode,
                    'email': this.email
                }).then(res => {
                    this.loading=false
                    this.e1 = 2
                }).catch(err => {
                    this.loading = false
                    console.log(err.response)
                })

            }
        },
        generateCode() {
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < 6; i++) {
                this.verificationCode += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
        },
        confirmCode() {
            if (this.$refs.form2.validate()) {
                if (this.verifyingCode == this.verificationCode) {
                    this.e1 = 3
                }else{
                    this.verificationError='Your code did not match. Try again.'
                }
            }
        },

        changePassword() {
            if (this.$refs.form3.validate()) {
                this.loading=true
                axios.post('api/resetPassword', {
                    'email':this.email,
                    'newPassword': this.newPassword,
                }).then(res => {
                    localStorage.setItem("token", res.data.token)
                    localStorage.setItem("role", res.data.user)
                        this.auth = res.data.auth_user
                        this.loading=false
                        this.unsetForgotPasswordDialog()
                        window.location.reload()
                }).catch(err => {
                    console.log(err.response)
                })

            }
        },
        placeEmail() {
            return 'words.auth.email'
        },
        placeCode() {
            return 'words.auth.enterCode'
        },
        placePassword() {
            return 'words.auth.newPassword'
        },
        placeConfirmPassword() {
            return 'words.auth.confirmNew'
        },

    }
}
</script>
