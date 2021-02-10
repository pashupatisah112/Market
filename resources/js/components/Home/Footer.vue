<template>
<div>
    <v-container fluid style="background-color:#333333">
        <v-row justify="center">
            <v-col cols="12" lg="4" md="6" sm="6" class="footer-color">
                <p class="font-weight-bolder">LOGO</p>
                <p class="caption">Address:60-49 Road 11378 New York</p>
                <p class="caption">Phone: +977-9815790619</p>
                <p class="caption">Email: hello@colorlib.com</p>
            </v-col>
            <v-col cols="12" lg="4" md="6" sm="6">
                <h4 class="white--text mt-">Useful Links</h4>
                <v-row>
                    <v-col cols="6" class="footer-color">
                        <p class="caption">About Us</p>
                        <p class="caption">About Our Shop</p>
                        <p class="caption">Secure Shopping</p>
                        <p class="caption">Delivery Information</p>
                        <p class="caption">Privacy Policy</p>
                        <p class="caption">Our Sitemap</p>
                    </v-col>
                    <v-col cols="6" class="footer-color">
                        <p class="caption">Who We Are</p>
                        <p class="caption">Our Services</p>
                        <p class="caption">Projects</p>
                        <p class="caption">Contact</p>
                        <p class="caption">Information</p>
                        <p class="caption">Testimonials</p>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" lg="4" md="6" sm="6" class="footer-color">
                <h4 class="white--text">Join Our Newsletter Now</h4>
                <p class="caption">Get E-mail updates about our latest shop and special offers.</p>
                <v-text-field flat tile solo rounded placeholder="Enter your email">
                    <template slot="append">
                        <v-btn rounded class="white--text text-capitalize mr-n4" color="blackTheme">Subscribe</v-btn>
                    </template>
                </v-text-field>
                <v-row justify="center">
                    <v-btn icon color="footer">
                        <v-icon>mdi-facebook</v-icon>
                    </v-btn>

                    <v-btn icon color="footer">
                        <v-icon>mdi-instagram</v-icon>
                    </v-btn>

                    <v-btn icon color="footer">
                        <v-icon>mdi-twitter</v-icon>
                    </v-btn>

                    <v-btn icon color="footer">
                        <v-icon>mdi-pinterest</v-icon>
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
