<template>
<div>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" align="center">
                <p class="text-h4 font-weight-bold">Contact Us</p>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" lg="4" md="4" align="center">
                <v-icon size="60" color="orange">mdi-map-marker</v-icon>
                <p class="font-weight-bold title blue--text">Address</p>
                <p>
                    Gokarneshwor -08, Narayantar<br>
                    Kathmandu, Nepal
                </p>
            </v-col>
            <v-col cols="12" lg="4" md="4" align="center">
                <v-icon size="50" color="orange">mdi-phone</v-icon>
                <p class="font-weight-bold title blue--text">Phone</p>
                <p>
                    +977 01 4914096
                </p>
            </v-col>
            <v-col cols="12" lg="4" md="4" align="center">
                <v-icon size="50" color="orange">mdi-email</v-icon>
                <p class="font-weight-bold title blue--text">Email</p>
                <p>
                    esmartorder@gmail.com
                </p>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-img src="../images/map.png">
                <p class="caption">Esmart Order</p>
                </v-img>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>

export default {
    data() {
        return {
            center: {
                lat: 45.508,
                lng: -73.587
            },
        }
    },
    mounted() {
        this.geolocate()
    },
    methods: {
        geolocate: function () {
            navigator.geolocation.getCurrentPosition(position => {
                this.center = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
            });
        },
    },
}
</script>
