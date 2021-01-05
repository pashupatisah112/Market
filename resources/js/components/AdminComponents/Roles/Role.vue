<template>
<div>
    <!--roles details at glance-->
    <v-container fluid>
        <v-row>
            <v-col cols="12" lg="2" md="3" sm="4" xs="6" v-for="role_item in role_items" :key="role_item.title">
                <v-card class="mx-auto" max-width="344" elevation="1">
                    <v-list-item three-line>
                        <v-list-item-avatar>
                            <v-icon x-large color="main" size="25">{{
                                role_item.icon
                            }}</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title class="headline mb-1">{{role_item.value}}</v-list-item-title>
                            <v-list-item-subtitle>{{role_item.title}}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                </v-card>
            </v-col>
        </v-row>
        <v-row class="mt-5" justify="center">
            <p class="headline text-lg-center font-weight-bold">Courses</p>
        </v-row>

    </v-container>
    <!--end course details-->

    <!--Course List-->
    <v-data-table :headers="headers" :items="roles" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="main">
                    <v-card-actions>
                        <v-icon x-large color="white">mdi-account-star</v-icon>
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>Roles Management</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <!--add new course -->
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on:dialog,attrs }">
                        <v-tooltip top>
                            <template v-slot:activator="{ on:tooltip }">
                                <v-btn class="mr-2 float-right" fab dark color="main" v-bind="attrs" v-on="{...dialog,...tooltip}">
                                    <v-icon dark>mdi-plus</v-icon>
                                </v-btn>
                            </template>
                            <span>Add New</span>
                        </v-tooltip>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" lg="12">
                                        <v-text-field v-model="editedItem.role_name" :rules="roleRules"></v-text-field>
                                        <p class="caption" style="color:red;margin-top:-15px">{{errors[0]}}</p>
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
                <!--end add-->
            </v-toolbar>
        </template>
        <!--data action -->
        <template v-slot:item.actions="{ item }">
            <!--edit button-->
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon small class="mr-2" @click="editItem(item)" v-bind="attrs" v-on="on">
                        mdi-pencil
                    </v-icon>
                </template>
                <span>Edit Role</span>
            </v-tooltip>
            <!--end edit button-->
            
            <!--delete button-->
            <v-dialog v-model="deleteDialog" persistent max-width="400" :retain-focus="false">
                <!--retain-focus helps prevent from maximum exceeding error caused when two items are deleted continuously. this is a bug so add this props compulsarily-->
                <template v-slot:activator="{ on:dialog,attrs  }">
                    <v-tooltip top>
                        <template v-slot:activator="{ on:tooltip }">
                            <!------v-on modified for double activator--------->
                            <v-icon small @click="deleteDialog = true" v-bind="attrs" v-on="{...tooltip,...dialog}">
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Delete</span>
                    </v-tooltip>
                </template>
                <v-card>
                    <v-card-title class="headline">Delete Confirmation</v-card-title>
                    <v-card-text>Are you sure you want to delete this role?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="deleteDialog = false">Cancel</v-btn>
                        <v-btn color="green darken-1" text @click="deleteItem(item)">Confirm</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!--end delete button-->
        </template>
        <!--end data sction-->
        <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
    </v-data-table>
    <!--end course list-->

    <!--snackbar for data update-->
    <v-snackbar v-model="dataUpdateAlert" :color="alertColor" :timeout="timeout">
        <v-icon color="white" style="margin-right:10px">mdi-checkbox-marked-circle</v-icon>
        {{dataUpdateMsg}}
        <v-btn color="white" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
    <!--end snackbar-->
</div>
</template>

<script>
export default {
    data: () => ({
        alertColor: 'success',
        timeout: 2000,
        dataUpdateMsg: '',
        dataUpdateAlert: false,
        alert: true,
        dialog: false,
        deleteDialog: false,
        role_items: [{
                title: "Staffs",
                value: 0,
                icon: "mdi-account-group"
            },
            {
                title: "Students",
                value: 0,
                icon: "mdi-school"
            },
            {
                title: "Teachers",
                value: 0,
                icon: "mdi-teach"
            },
            {
                title: "Colleges",
                value: 0,
                icon: "mdi-home-city"
            },
            {
                title: "Institute",
                value: 0,
                icon: "mdi-home-modern"
            },
            {
                title: "Consultancies",
                value: 0,
                icon: "mdi-account-child"
            },
        ],
        headers: [{
                text: '#',
                align: 'start',
                sortable: false,
                value: 'id',
            },
            {
                text: 'Role Name',
                value: 'role_name'
            },
            {
                text: 'Created at',
                value: 'created_at'
            },
            {
                text: 'Updated at',
                value: 'updated_at'
            },
            {
                text: 'Actions',
                value: 'actions',
                sortable: false
            },
        ],
        roles: [],
        errors: [],
        roleRules: [
            v => !!v || 'Role Name is required',
        ],
        editedIndex: -1,
        editedItem: {
            id: '',
            role_name: '',
            created_at: '',
            updated_at: ''
        },
        defaultItem: {
            role_name: '',
        },
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Role' : 'Edit Role'
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
    mounted() {
        axios.get('/api/role/num', {})
            .then(res => Vue.set(this.role_items[0], 'value', res.data.staff_num), ).catch(err => console.log(err.response))

        axios.get('/api/role/num', {})
            .then(res => Vue.set(this.role_items[1], 'value', res.data.student_num), ).catch(err => console.log(err.response))

        axios.get('/api/role/num', {})
            .then(res => Vue.set(this.role_items[2], 'value', res.data.teacher_num), ).catch(err => console.log(err.response))

        axios.get('/api/role/num', {})
            .then(res => Vue.set(this.role_items[3], 'value', res.data.college_num), ).catch(err => console.log(err.response))

        axios.get('/api/role/num', {})
            .then(res => Vue.set(this.role_items[4], 'value', res.data.institute_num), ).catch(err => console.log(err.response))

        axios.get('/api/role/num', {})
            .then(res => Vue.set(this.role_items[5], 'value', res.data.consultant_num), ).catch(err => console.log(err.response))
    },

    methods: {
        initialize() {
            this.roles = []
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
            axios.get('/api/roles', {}).
            then(res => this.roles = res.data.roles)

        },

        editItem(item) {
            this.editedIndex = this.roles.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            const index = this.roles.indexOf(item)
            this.roles.splice(index, 1)
            axios.delete('/api/roles/' + item.id)
                .then(
                    this.deleteDialog = false,
                    this.dataUpdateMsg = 'Role item deleted successfully',
                    this.dataUpdateAlert = true
                )
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
                axios.put('/api/roles/' + this.editedItem.id, {
                        'role_name': this.editedItem.role_name
                    })
                    .then(
                        res => {
                            if (Object.assign(this.roles[this.editedIndex], res.data.roles)) {
                                this.close()
                                this.dataUpdateMsg = 'Role item Updated successfully',
                                    this.dataUpdateAlert = true
                            }
                        }
                    )
                    .catch(
                        err => {
                            if (err.response.status == 422) {
                                this.errors = err.response.data.errors.role_name
                            }
                        })
                Object.assign(this.roles[this.editedIndex], this.editedItem)
            } else {
                axios.post('/api/roles', {
                        'role_name': this.editedItem.role_name
                    })
                    .then(res => {
                            if (this.roles.push(res.data.roles)) {
                                this.close()
                                this.dataUpdateMsg = 'Role item Added successfully',
                                    this.dataUpdateAlert = true
                            }
                        }

                    )
                    .catch(err => {
                        if (err.response.status == 422) {
                            this.errors = err.response.data.errors.role_name
                        }
                    })
            }
            //this.close();
        }
    },
}
</script>
