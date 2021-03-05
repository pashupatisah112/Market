<template>
    <v-container fluid>
        <!--customer list-->
        <v-data-table :headers="headers" :items="customers.data" class="elevation-1" :footer-props="{ itemsPerPageOptions: [5, 10, 15],itemsPerPageText:'Customers per page' }"
            :server-items-length="customers.total"
            :loading="loading"
            loading-text="Loading.....Please wait."
            @pagination="paginate">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                        <v-card-actions>
                            <p class="white--text">{{ customers.total }}</p>
                        </v-card-actions>
                    </v-card>
                    <v-toolbar-title>Customers Management</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                </v-toolbar>
            </template>
            <template v-slot:no-data>
                <p>No Data Found</p>
                <v-btn color="primary" @click="paginate">Reset</v-btn>
            </template>
        </v-data-table>
        <!--end customer list-->
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            loading:false,
            headers: [
                {
                    text: "#",
                    align: "start",
                    sortable: false,
                    value: "id"
                },
                {
                    text: "Name",
                    value: "name"
                },
                {
                    text: "Email",
                    value: "email"
                }
            ],
            customers: []
        };
    },
    methods: {
        paginate($event){
            axios
                .post("/api/customers?page="+$event.page, {'per_page':$event.itemsPerPage}) //see the response to understand this-page urls
                .then(res => {
                    this.customers = res.data;
                })
                .catch(err => console.log(err.response));
        }
    }
};
</script>
