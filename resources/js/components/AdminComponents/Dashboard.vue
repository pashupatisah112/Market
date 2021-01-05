<template>
<v-container fluid>
    <v-row>
        <v-col cols="6" v-for="data in analytics" :key="data.title">
            <v-card class="mt-4 mx-auto">
                <v-sheet class="v-sheet--offset mx-auto" color="main" elevation="12" max-width="calc(100% - 32px)">
                    <v-sparkline :labels="data.labels" :value="data.value" color="white" line-width="2" padding="16"></v-sparkline>
                </v-sheet>
                <v-card-actions class="py-0">
                    <div class="title font-weight-light mb-2">
                        {{data.title}}
                    </div>
                    <v-spacer></v-spacer>
                    <div class="title font-weight-light mb-2">
                        {{data.total}}
                    </div>
                </v-card-actions>
                <v-divider class="my-2"></v-divider>
                <v-card-text class="pt-0">
                    <v-icon class="mr-2" small>
                        {{data.footer_icon}}
                    </v-icon>
                    <span class="caption grey--text font-weight-light">{{data.footer_data}} {{data.footer_title}}</span>
                </v-card-text>
            </v-card>
            <!-- <v-row class="px-3">
                <v-col v-for="card in cards" :key="card.title" cols="12" lg="3" md="4" sm="6" xs="12" class="mt-5">
                    <v-card height="100">
                        <v-container fluid>
                            <v-row class="pr-2">
                                <v-col>
                                    <v-card class="py-2 mt-n12" color="success">
                                        <v-card-actions class="justify-center">
                                            <v-icon x-large color="white">{{card.icon}}</v-icon>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
                                <v-col>
                                    <p class="font-weight-bold text-lg-right headline">{{card.detail }}</p>
                                    <p class="font-weight-light text-lg-right">{{ card.title }}</p>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-divider></v-divider>
                                <v-icon color="background">{{card.footer_icon}}</v-icon>
                                <p class="font-weight-light">{{ card.footer_title }}</p>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row> -->
        </v-col>
    </v-row>
</v-container>
</template>

<script>
export default {
    data: () => ({
        analytics: [{
                title: 'Registered Users',
                total: '50,000',
                footer_icon: 'mdi-account-plus',
                footer_title: 'new registration today',
                footer_data:'26',
                labels: [
                    '12am',
                    '3am',
                    '6am',
                    '9am',
                    '12pm',
                    '3pm',
                    '6pm',
                    '9pm',
                ],
                value: [
                    200,
                    675,
                    410,
                    390,
                    310,
                    460,
                    250,
                    240,
                ],
            },
            {
                title: 'Online',
                total: '50,000',
                footer_icon: 'mdi-account-tie-voice',
                footer_title: 'online last hour',
                footer_data:'12',
                labels: [
                    '12am',
                    '3am',
                    '6am',
                    '9am',
                    '12pm',
                    '3pm',
                    '6pm',
                    '9pm',
                ],
                value: [
                    200,
                    675,
                    410,
                    390,
                    310,
                    460,
                    250,
                    240,
                ],
                
            },
            {
                title: 'Premium Users',
                total: '50,000',
                footer_icon: 'mdi-account-heart',
                footer_title: 'remium subscription today',
                footer_data:'2',
                labels: [
                    '12am',
                    '3am',
                    '6am',
                    '9am',
                    '12pm',
                    '3pm',
                    '6pm',
                    '9pm',
                ],
                value: [
                    200,
                    675,
                    410,
                    390,
                    310,
                    460,
                    250,
                    240,
                ],
            },
            {
                title: 'Anonymous',
                total: '50,000',
                footer_icon: 'mdi-account-convert',
                footer_title: 'anonymous users today',
                footer_data:'100',
                labels: [
                    '12am',
                    '3am',
                    '6am',
                    '9am',
                    '12pm',
                    '3pm',
                    '6pm',
                    '9pm',
                ],
                value: [
                    200,
                    675,
                    410,
                    390,
                    310,
                    460,
                    250,
                    240,
                ],
            },
        ],

    }),
}
</script>

<style>
.v-sheet--offset {
    top: -24px;
    position: relative;
}
</style>
