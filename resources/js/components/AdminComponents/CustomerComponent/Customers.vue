<template>
<v-container fluid>

    <!--heading-->
    <v-row class="mt-5" justify="center">
        <p class="headline text-lg-center font-weight-bold">Customers</p>
    </v-row>
    <!--end heading-->

    <!--customer list-->
    <v-data-table :headers="headers" :items="customers" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                    <v-card-actions>
                        <v-icon x-large color="white">mdi-account-star</v-icon>
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>Customers Management</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
            </v-toolbar>
        </template>yyy
        <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
    </v-data-table>
    <!--end customer list-->
</v-container>
</template>

<script>

export default {
    
    data() {
        return {
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Name',
                    value: 'name'
                },
                {
                    text: 'Email',
                    value: 'email'
                },
            ],
            customers: [],
        }
    },

    created() {
        this.initialize()
    },
    methods: {
        initialize() {
            this.customers = []
            axios.get('/api/customers', {}).
            then(res => this.customers = res.data.customers)
                .catch(err => console.log(err.response))

        },
    },

}
</script>
