<template>
<div>
    <v-container fluid>
        <v-row justify="center">
            <v-col cols="12" align="center">
                <v-card class="" width="400" style="background-color:rgba(0,0,0,0.5)">
                    <v-card-title class="mx-auto white--text font-weight-bold">EsmartOrder Admin Panel</v-card-title>
                    <v-card-text>
                        <v-form v-model="valid" ref="form">
                            <v-text-field v-model="adminEmail" :error-messages="loginError" light solo placeholder="Emaill address" prepend-inner-icon="mdi-account-lock" :rules="[validRules.required,validRules.email]"></v-text-field>
                            <v-text-field v-model="adminPassword" type="password" light solo placeholder="Password" prepend-inner-icon="mdi-shield-lock" :rules="[validRules.required]"></v-text-field>
                            <v-btn rounded block class="white--text text-capitalize" @click="adminLogin">Login</v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
import {
    mapState, mapMutations
} from 'vuex';
export default {
    data() {
        return {
            valid: true,
            adminEmail: '',
            adminPassword: '',
            loginError: ''
        }
    },
    computed: {
        ...mapState({
            validRules: state => state.validation.validRules,
            token:state=>state.authentication.token,
            auth:state=>state.authentication.auth
        })
    },
    mounted() {
        this.checkToken()
    },
    methods: {
        ...mapMutations(['setAuth']),
        checkToken() {
            // if(localStorage.getItem('role')=='admin'){
            //     this.$router.push({
            //                     name: 'AdminDashboard'
            //                 })
            // }
        },
        adminLogin() {
            if (this.$refs.form.validate()) {
                axios
                    .post("/api/admin-login", {
                        email: this.adminEmail,
                        password: this.adminPassword,
                        role_id: 1
                    })
                    .then(res => {
                        if (res.data.admin.role_id == 1) {
                            localStorage.setItem("token", res.data.token);
                            localStorage.setItem("role", 'admin');
                            this.setAuth(res.data.admin)
                            this.$router.push({
                                name: 'AdminDashboard'
                            })
                        }else{
                            this.loginError="Unauthorized"
                            this.$refs.form.reset()
                        }

                    })
                    .catch(err => {
                        this.loginError = err.response.data.status
                    });
            }
        }
    }
}
</script>
