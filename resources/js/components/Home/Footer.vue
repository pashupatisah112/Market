<template>
<div>
    <v-container fluid style="background-color:#009E9A">
        <v-row justify="center">
            <v-col cols="12" lg="4" md="6" sm="6" class="footer-color">
                <p class="font-weight-bolder">LOGO</p>
                <p class="caption">{{ $t('words.footer.address') }}:Narayantar, Gokarneshwor-08 Kathmandu</p>
                <p class="caption">{{ $t('words.footer.phone') }}: +977-9815790619</p>
                <p class="caption">{{ $t('words.footer.email') }}: esmartorder@gmail.com</p>
            </v-col>
            <v-col cols="12" lg="4" md="6" sm="6">
                <h4 class="white--text mt-">{{ $t('words.footer.usefulLinks') }}</h4>
                <v-row>
                    <v-col cols="6" class="footer-color">
                        <p class="caption line-hover" @click="goToAbout">{{ $t('words.footer.about') }}</p>
                        <!-- <p class="caption line-hover" @click="goToContact">{{ $t('words.footer.contact') }}</p> -->
                    </v-col>
                    <v-col cols="6" class="footer-color">
                        <p class="caption line-hover" @click="goToTerms">{{ $t('words.footer.terms') }}</p>
                        <p class="caption line-hover" @click="goToPolicy">{{ $t('words.footer.privacyPolicy') }}</p>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" lg="4" md="6" sm="6" class="footer-color">
                <h4 class="white--text">{{ $t('words.footer.joinNewsletter') }}</h4>
                <p class="caption">{{ $t('words.footer.getEmail') }}</p>
                <v-form ref="form" v-model="valid">
                    <v-text-field flat tile solo rounded placeholder="Enter your email" v-model="newsletter" :rules="[validRules.required,validRules.email]">
                        <template slot="append">
                            <v-btn rounded class="white--text text-capitalize mr-n4" color="blackTheme" @click="joinNewsletter">{{ $t('words.footer.subscribe') }}</v-btn>
                        </template>
                    </v-text-field>
                </v-form>

                <v-row justify="center">
                    <v-btn icon color="footer" href="https://www.facebook.com/eSmartOrder" target="_blank">
                        <v-icon>mdi-facebook</v-icon>
                    </v-btn>

                    <v-btn icon color="footer" href="https://www.instagram.com/esmartorder/" target="_blank">
                        <v-icon>mdi-instagram</v-icon>
                    </v-btn>

                </v-row>
            </v-col>
        </v-row>
        <v-divider class="my-2"></v-divider>
        <v-row>
            <v-col cols="12" lg="6" md="6" sm="6">
                <p class="font-weight-bolder footer-color">Copyright <v-icon></v-icon>2020 ALL rights reserved. Developed by Technogen</p>
            </v-col>
            <v-col cols="12" lg="6" md="6" sm="6" align="right">
                <v-row>
                    <v-spacer></v-spacer>
                    <div style="width:75px;height:40px;margin-right:10px">
                        <v-img src="../images/khalti.png"></v-img>
                    </div>

                    <div style="width:75px;height:40px;margin-right:10px">
                        <v-img src="../images/esewa.png"></v-img>
                    </div>
                </v-row>

            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
import firebase from "firebase/app";
import {
    mapState
} from 'vuex'
export default {
    data() {
        return {
            valid: true,
            newsletter: '',
        }
    },
    computed: {
        ...mapState({
            validRules: state => state.validation.validRules
        })
    },
    methods: {
        joinNewsletter() {
            if (this.$refs.form.validate()) {
                db.collection("newsletter").doc(this.newsletter).set({
                        email: this.newsletter,
                    })
                    .then(() => {
                        this.newsletter = ''
                        this.$toast.success({
                            title: "Newsletter",
                            message: "Thanks you for subscribing our newsletter."
                        });
                    })
                    .catch((error) => {
                        console.error("Error writing document: ", error);
                    });
            }
        },
        goToAbout() {
            this.$router.push({
                path: "about"
            })
        },
        goToContact() {
            this.$router.push({
                path: "contact"
            })
        },
        goToTerms() {
            this.$router.push({
                path: "terms"
            })
        },
        goToPolicy() {
            this.$router.push({
                path: "policy"
            })
        }

}
}
</script>
