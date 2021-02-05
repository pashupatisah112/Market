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
                    total users
                    total orders
                    option to select year and month to generate report data
                    add notification for new users,new orders,new comments
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
            monthNames: ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ]

        }

    },
    mounted() {

    },
    methods: {
        getMonth() {
            let index = new Date().getMonth()
            return this.monthNames[index]
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
