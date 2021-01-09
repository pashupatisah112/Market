<template>
<div>
    <v-container fluid style="padding:0px">
        <v-img src="../images/admin-background.jpg" style="width:100%;height:100%">
            <v-container fluid>
                <v-row justify="center">
                    <v-col cols="12">
                        <v-card class="mx-auto my-auto" width="400" style="background-color:rgba(0,0,0,0.5)">
                            <v-card-title>Admin Login</v-card-title>
                            <v-card-text>
                                <v-form v-model="valid" ref="form">
                                    <v-text-field v-model="adminEmail" light solo placeholder="Emaill address" prepend-inner-icon="mdi-account-lock"></v-text-field>
                                    <v-text-field v-model="adminPassword" light solo placeholder="Password" prepend-inner-icon="mdi-shield-lock"></v-text-field>
                                    <v-btn rounded block class="white--text text-capitalize" @click="adminLogin">Login</v-btn>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-img>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            valid: true,
            adminEmail:'',
            adminPassword:''
        }
    },
    computed: {
    },
    methods: {

        adminLogin() {
            if (this.$refs.form.validate()) {
                axios
                    .post("/api/admin-login", {
                        email: this.adminEmail,
                        password: this.adminPassword,
                        role_id:1
                    })
                    .then(res => {
                        console.log(res.data)
                        localStorage.setItem("token", res.data.token);
                        this.$router.push('/admin')
                            .catch(err => console.log(err));
                    })
                    .catch(err => {
                        // this.state.snackMessage = err.response.data.status;
                        // this.state.snackbar = true;
                        console.log(err.response)
                    });
            }
        }
    }
}
</script>
