<template>
<div>
    <v-dialog max-width="600" v-model="loginDialog" persistent>
        <v-card>
            <v-container fluid>
                <v-row>
                    <v-col cols="6" class="pa-0">
                        <v-img src="../images/login-background.jpg"></v-img>
                    </v-col>
                    <v-col cols="6" class="background pa-0">
                        <v-card style="height:100%" flat class="pa-0">
                            <v-btn small icon class="float-right mr-1" @click="unsetLoginDialog">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                            <div class="pa-5">
                                <p class="text-center font-weight-bold">Customer Login</p>
                                <v-form ref="form" v-model="valid">
                                    <v-text-field :rules="[validRules.required,validRules.email]" :error-messages="loginError" placeholder="Email" prepend-icon="mdi-email" v-model="email" rounded dense solo filled></v-text-field>
                                    <v-text-field :rules="[validRules.required,validRules.lengthMin8]" placeholder="Password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" @click:append="show1 = !show1" :type="show1 ? 'text' : 'password'" prepend-icon="mdi-lock" v-model="password" rounded dense solo filled></v-text-field>
                                    <v-checkbox label="Remember me" color="red" value="red" v-model="remember_me" hide-details class="mt-n4 ml-8 mb-2"></v-checkbox>
                                </v-form>

                                <v-btn rounded block dark @click="login" class="mb-2">Login</v-btn>

                                <p class="caption line-hover" @click="registerMode=true">Create your account</p>
                                <p class="caption mt-n2">Forgot password? <span class="line-hover">Click Here</span></p>
                                <v-row justify="center">

                                    <!-- <v-btn small class="text-capitalize mb-2 mx-auto" dark color="#ea4335" rounded @click="googleLogin">
                                        <v-icon class="mr-3" small>mdi-google</v-icon>
                                        Login using google
                                    </v-btn> -->
                                    <!-- <v-btn small rounded class="text-capitalize mb-2" dark color="#3b5998" @click="facebookLogin">
                                        <v-icon class="mr-3" small>mdi-facebook</v-icon>
                                        Login with facebook
                                    </v-btn> -->
                                     <!-- <GoogleLogin :params="params" :onSuccess="onSuccess" :logoutButton=true>Login</GoogleLogin> -->

                                    <v-facebook-login app-id="345745223374461" v-model="model" @sdk-init="handleSdkInit">
                                    </v-facebook-login>
                                    
                                </v-row>
                            </div>

                            <v-expand-transition>
                                <div v-if="registerMode" class="transition-fast-in-fast-out v-card--reveal" style="height: 100%;opacity:1">
                                    <v-card style="height:100%" flat>
                                        <div class="pa-5">
                                            <p class="text-center font-weight-bold">Create Account</p>
                                            <v-form ref="form" v-model="valid">
                                                <v-text-field :rules="[validRules.required]" placeholder="Full Name" prepend-icon="mdi-account" v-model="name" rounded dense solo filled></v-text-field>
                                                <v-text-field v-if="emailMode" :rules="[validRules.required,validRules.email]" :error-messages="emailError" placeholder="Email" prepend-icon="mdi-email" append-icon="mdi-phone-remove" @click:append="emailMode=false" v-model="email" rounded dense solo filled></v-text-field>
                                                <v-text-field v-else :rules="[validRules.required,validRules.length10,validRules.numberAll]" placeholder="Phone" prepend-icon="mdi-cellphone" append-icon="mdi-email-off" @click:append="emailMode=true" v-model="phone" rounded dense solo filled></v-text-field>
                                                <v-text-field :rules="[validRules.required,validRules.lengthMin8]" placeholder="Password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" @click:append="show1 = !show1" :type="show1 ? 'text' : 'password'" prepend-icon="mdi-lock" v-model="password" rounded dense solo filled></v-text-field>
                                                <v-row>
                                                    <v-checkbox :rules="[v => !!v || 'You must agree to continue!']" class="mt-n2 ml-8" color="green" value="red" hide-details></v-checkbox>
                                                    <p class="text--secondary body-2">Agree to <span class="line-hover" @click="termsDialog=true">Terms and Conditions</span></p>
                                                </v-row>
                                                <v-btn rounded dark block @click="register" class="text-capitalize my-2">Create Account</v-btn>
                                            </v-form>
                                            <p class="caption line-hover" @click="registerMode=false">Login to your account</p>
                                        </div>
                                    </v-card>
                                </div>
                            </v-expand-transition>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>

        </v-card>
    </v-dialog>
    <policy></policy>
</div>
</template>

<script>
import Policy from '../Other/Policy';
import VFacebookLogin from 'vue-facebook-login-component';
 import GoogleLogin from 'vue-google-login';
import {
    mapState,
    mapMutations
} from 'vuex';
export default {
    components: {
        Policy,
        VFacebookLogin,
        GoogleLogin
    },
    data() {
        return {
            show1: false,
            registerMode: false,
            emailMode: true,
            valid: true,
            remember_me: false,
            email: null,
            loginError: '',
            emailError: '',
            password: '',
            name: '',
            phone: null,
            auth: null,

            //facebook login
            FB: {},
            model: {},
            scope: {},

            //google login
            params: {
                    client_id: "esmartorder-306815"
                },
        }
    },
    computed: {
        ...mapState({
            token: state => state.authentication.token,
            loginDialog: state => state.authentication.loginDialog,
            validRules: state => state.validation.validRules
        })
    },
    methods: {
        ...mapMutations(['unsetLoginDialog', 'setAuth', 'setToken']),

        login() {
            if (this.$refs.form.validate()) {
                axios
                    .post("/api/customer-login", {
                        email: this.email,
                        password: this.password,
                        remember_me: this.remember_me
                    })
                    .then(res => {
                        if (res.data.auth_user.role_id == 2) {
                            localStorage.setItem("token", res.data.token);
                            localStorage.setItem("role", res.data.user);
                            this.unsetLoginDialog()
                            this.setAuth(res.data.auth_user)
                            this.setToken()
                            window.location.reload()
                        } else {
                            this.loginError == "Unauthorized"
                        }
                    })
                    .catch(err => {
                        this.loginError = err.response.data.status
                    });
            }
        },
        facebookLogin() {
            axios.get('api/social/auth/redirect/facebook')
                .then(res => console.log(res.data))
                .catch(err => console.log(err.response))
        },
        googleLogin() {
            axios.get('api/google/auth/redirect')
                .then(res => console.log(res.data))
                .catch(err => console.log(err.response))
        },
        register() {
            if (this.$refs.form.validate()) {
                axios.post('/api/register', {
                        'name': this.name,
                        'email': this.email,
                        'phone': this.phone,
                        'password': this.password,
                        'role_id': 2,
                    })
                    .then(res => {
                        localStorage.setItem("token", res.data.token);
                        this.auth = res.data.auth_user
                        db.collection("notification").add({
                            user_name: this.name,
                            type: 'user',
                            created_at: new Date(),
                            read_at: null,
                        })
                        window.location.reload()
                            .catch(err => console.log(err));
                    }).catch(err => {
                        this.emailError = err.response.data.errors.email[0]
                    })
            }
        },
        getUserData(e){
            console.log(e)
            console.log(this.model)
        },
        onSuccess(googleUser) {
            console.log('google:',googleUser);

            // This only gets the user information: id, name, imageUrl and email
            console.log(googleUser.getBasicProfile());
        },
        handleSdkInit({
            FB,
            scope
        }) {
            this.FB = FB
            this.scope = scope
            console.log('fb:', this.FB)
        },

    }
}
</script>
