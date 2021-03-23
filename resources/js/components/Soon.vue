<template>
<v-app>
    <v-main>
        <v-container fluid>
            <v-row>
                <v-col cols="12" lg="6" md="6" class="pa-0">
                    <v-img src="../images/back.jpg" :aspect-ratio="16/16">
                        <div style="width:100%;height:100%;background-color:rgba(0,150,255,0.5);" class="white--text">
                            <countdown :time="time">
                                <template slot-scope="props">
                                    <v-container>
                                        <v-row justify="center" style="margin-top:35%">
                                            <v-col cols="3" align="center">
                                                <p class="text-h4 text-md-h3 text-lg-h2 font-weight-bold">{{ props.days }}</p>
                                                <p class="text-lg-h6 text-md-h6">Days</p>
                                            </v-col>
                                            <v-col cols="3" align="center">
                                                <p class="text-h4 text-md-h3 text-lg-h2 font-weight-bold">{{ props.hours }}</p>
                                                <p class="text-lg-h6 text-md-h6">Hours</p>
                                            </v-col>
                                            <v-col cols="3" align="center">
                                                <p class="text-h4 text-md-h3 text-lg-h2 font-weight-bold">{{ props.minutes }}</p>
                                                <p class="text-lg-h6 text-md-h6">Minutes</p>
                                            </v-col>
                                            <v-col cols="3" align="center">
                                                <p class="text-h4 text-md-h3 text-lg-h2 font-weight-bold">{{ props.seconds }}</p>
                                                <p class="text-lg-h6 text-md-h6">Seconds</p>
                                            </v-col>

                                        </v-row>
                                    </v-container>
                                </template>
                            </countdown>
                        </div>
                    </v-img>
                </v-col>
                <v-col cols="12" lg="6" md="6">
                    <v-container fluid>
                        <v-row justify="center">
                            <v-col cols="6" align="center">
                                <v-img src="../images/logo.png" style="max-width:500px;height:auto;margin-bottom:-20%"></v-img>
                            </v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col align="center">
                                <p style="letter-spacing:1px">STAY TUNED</p>
                                <p class="text-lg-h4 text-h6 text-md-h4 font-weight-bold text-capitalize">We will launch soon</p>
                                <p class="caption">Subscribe to get notification as soon as we launch!</p>
                                <v-form v-model="valid" ref="form" class="px-5">
                                    <v-row>
                                        <v-text-field v-model="text" :error-messages="error" class="mr-2" :rules="emailRules" outlined rounded placeholder="Enter Your Email"></v-text-field>
                                        <v-btn dark rounded x-large class="btn-style mx-auto" @click="submit">Notify me</v-btn>
                                    </v-row>
                                </v-form>
                            </v-col>
                        </v-row>
                        <v-row justify="center" style="margin-top:15%">
                            <v-col align="center">
                                <v-btn icon small @click="facebook">
                                    <v-icon dense size="22">mdi-facebook</v-icon>
                                </v-btn>
                                <v-btn icon small>
                                    <v-icon dense size="22">mdi-twitter</v-icon>
                                </v-btn>
                                <v-btn icon small>
                                    <v-icon dense size="22">mdi-linkedin</v-icon>
                                </v-btn>
                                <v-btn icon small>
                                    <v-icon dense size="22">mdi-instagram</v-icon>
                                </v-btn>
                            </v-col>

                        </v-row>
                        <v-row justify="center">
                            <p class="mr-5"><b>Phone:</b> <span class="text--secondary">+977 9815790619</span></p>
                            <p><b>Email:</b> <span class="text--secondary">esmartorder@gmail.com</span></p>
                        </v-row>
                    </v-container>
                </v-col>

            </v-row>
            <v-snackbar :timeout="timeout" v-model="snack" absolute bottom color="#60ddd7" outlined right class="mx-auto" style="position:absolute">
                {{msg}}
            </v-snackbar>
        </v-container>
    </v-main>

</v-app>
</template>

<script>
import firebase from 'firebase/app';
export default {
    data() {
        var now = new Date();
        var launch = new Date(now.getFullYear() + 0, 0, 90);

        return {
            valid: true,
            text: '',
            error: '',
            snack: false,
            msg: '',
            timeout: 2000,
            time: launch - now,
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
        }
    },

    methods: {
        submit() {
            if (this.$refs.form.validate()) {
                db.collection("emails").add({
                        email: this.text,
                    })
                    .then((docRef) => {
                        this.snack = true
                        this.msg = 'Your email has been recorded. Thank you for choosing us!!'
                        this.$refs.form.reset()
                    })
                    .catch((error) => {
                        this.error = 'Problem recording your email.'
                    });
            }
        },
        facebook() {
            window.location = 'https://www.facebook.com/EsmartOrder'
        },
    }
}
</script>

<style lang="css">
.border {
    border: 1px solid red;
}

.btn-style {

    /* box-shadow: 5px 10px 30px black; */
    background-image: linear-gradient(to right, #60ddd7, #3390eccc);
}
</style>
