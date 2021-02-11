<template>
<v-container fluid>
    <v-row>
        <v-col cols="12">
            <v-row>
                <v-col cols="6">
                    <chart></chart>
                    <p class="text-center font-weight-bold">{{getMonth()}} {{new Date().getFullYear()}}</p>
                </v-col>
                <v-col cols="5">
                    <p class="font-weight-bold mt-10">Total Users: {{totalUser}}</p>
                    <p class="font-weight-bold">Total Deliveries: {{totalDelivery}}</p>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import Chart from './Utility/Chart';

export default {
    components: {
        Chart
    },
    data() {
        return {
            totalUser:0,
            totalDelivery:0,
            monthNames: ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ]

        }

    },
    mounted() {
        this.getDisplayData()
    },
    methods: {
        getMonth() {
            let index = new Date().getMonth()
            return this.monthNames[index]
        },
        getDisplayData() {
            axios.get('api/getDisplayData')
                .then(res => {
                    this.totalUser=res.data.user_count
                    this.totalDelivery=res.data.delivery_count
                })
                .catch(err => console.log(err.response))
        }
    }
}
</script>

<style>
.v-sheet--offset {
    top: -24px;
    position: relative;
}
</style>
