<template>
<v-container fluid>
    <div class="mt-n10">
        <v-breadcrumbs :items="breadItems"></v-breadcrumbs>
    </div>
    <v-row class="mt-5" justify="center">
        <p class="headline text-lg-center font-weight-bold">Organization List</p>
    </v-row>

    <v-row>
        <v-data-table :headers="headers" :items="orgs" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-card class="px-3 py-3 mb-2 mr-2" color="success">
                        <v-card-actions>
                            <v-icon x-large color="white">mdi-account-star</v-icon>
                        </v-card-actions>
                    </v-card>
                    <v-toolbar-title>org Management</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on }">
                            <v-btn class="mr-2 float-right" fab dark color="success" v-on="on">
                                <v-icon dark>mdi-plus</v-icon>
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{
                                        formTitle
                                    }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field v-model="editedItem.name" label="org Name" :rules="nameRules"></v-text-field>
                                            <v-text-field v-model="editedItem.email" label="Email" :rules="emailRules"></v-text-field>
                                            <v-text-field v-model="editedItem.password" label="Password" :rules="passRules"></v-text-field>
                                            <v-select :items="roles" v-model="editedItem.role_id" label="Roles" item-text="role_name" item-value="id"></v-select>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="goTodetail(item.id)">
                    mdi-eye
                </v-icon>
                <v-icon small class="mr-2" @click="editItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon small @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
        </v-data-table>
    </v-row>
</v-container>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        nameRules: [
            v => !!v || 'Name is required',
            v => /^(?=.{3,30})/.test(v) || 'Name should be 3-30 characters long',
        ],
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        passRules: [
            v => !!v || 'Password is required',
            v => /^(?=.{8,})/.test(v) || 'Password must be minimum 8 characters long.',
            v => /^(?=.*[a-z])(?=.*[A-Z])/.test(v) || 'First letter should be capital',
            v => /^(?=.*[0-9])/.test(v) || 'Password must contain a number.'
        ],

        breadItems: [{
                text: "Dashboard",
                disabled: false,
                href: "/#/admin/dashboard"
            },
            {
                text: "org",
                disabled: true,
                href: ""
            }
        ],
        headers: [{
                text: '#',
                align: 'start',
                sortable: false,
                value: 'id',
            },
            {
                text: 'org Name',
                value: 'name'
            },
            {
                text: 'Email',
                value: 'email'
            },
            {
                text: 'Role',
                value: 'role.role_name'
            },
            {
                text: 'Actions',
                value: 'actions',
                sortable: false
            },
        ],
        roles: [],
        orgs: [],
        editedIndex: -1,
        editedItem: {
            name: '',
            email: '',
            password: '',
            role_id:''
        },
        defaultItem: {
            name: '',
            email: '',
            password: '',
            role_id:''
        },
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New org' : 'Edit org Details'
        },

    },
    watch: {
        dialog(val) {
            val || this.close()
        },
    },

    created() {
        this.initialize()

    },

    methods: {
        initialize() {
            this.courses = []
            axios.interceptors.request.use((config) => {
                this.loading = true;
                return config;
            }, (error) => {
                this.loading = false;
                return Promise.reject(error);
            });

            axios.interceptors.response.use((response) => {
                this.loading = false;
                return response;
            }, (error) => {
                this.loading = false;
                return Promise.reject(error);
            });
            axios.get('/api/orgs', {}).
            then(res => this.orgs = res.data.orgs)
                .catch(err => console.log(err.response))

            axios.get('/api/roles', {}).
            then(res => this.roles = res.data.roles)
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.orgs.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.orgs.indexOf(item)
            confirm('Are you sure you want to delete this item?') && this.orgs.splice(index, 1)
            axios.delete('/api/orgs/' + item.id)
                .then(res => this.snackbar = true)
        },

        close() {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save() {
            if (this.editedIndex > -1) {
                axios.put('/api/orgs/' + this.editedItem.id, {
                        'name': this.editedItem.name,
                        'email': this.editedItem.email,
                        'password': this.editedItem.email,
                    })
                    .then(res => Object.assign(this.orgs[this.editedIndex], res.data.orgs))
                    .catch(err => console.log(err.response))
                Object.assign(this.orgs[this.editedIndex], this.editedItem)
            } else {
                axios.post('/api/orgs', {
                        'name': this.editedItem.name,
                        'email': this.editedItem.email,
                        'password': this.editedItem.password,
                        'role_id':this.editedItem.role_id
                    })
                    .then(res => this.orgs.push(res.data.orgs))
                    .catch(err => console.dir(err.response))
            }
            this.close()
        },

    }
}
</script>

<style scoped>
.border {
    border-radius: 50px;
    background-color: green;
    padding: 10px;
}
</style>
