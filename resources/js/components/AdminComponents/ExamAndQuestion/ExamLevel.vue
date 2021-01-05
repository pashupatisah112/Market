<template>
<v-container fluid>
    <!--heading-->
    <v-row justify="center">
        <p class="headline text-lg-center font-weight-bold">Exam Levels</p>
    </v-row>
    <!--end heading-->

    <!--course list-->
    <v-data-table :headers="headers" :items="levels" sort-by="calories" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-card class="px-3 py-3 mb-2 mr-2" color="main">
                    <v-card-actions>
                        <v-icon x-large color="white">mdi-account-star</v-icon>
                    </v-card-actions>
                </v-card>
                <v-toolbar-title>Exam Level Management</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <!--add new course-->
                <v-dialog v-model="levelDialog" max-width="500px">
                    <template v-slot:activator="{ on:levelDialog,attrs }">
                        <v-tooltip top>
                            <template v-slot:activator="{ on:tooltip }">
                                <v-btn class="mr-2 float-right" fab dark color="main" v-bind="attrs" v-on="{...levelDialog,...tooltip}">
                                    <v-icon dark>mdi-plus</v-icon>
                                </v-btn>
                            </template>
                            <span>Add New</span>
                        </v-tooltip>
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
                                        <v-text-field v-model="editedItem.level_title" label="Exam Level Title" :rules="nameRules" :error-messages="errLevelName" required></v-text-field>
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
                <!--end add new-->
            </v-toolbar>
        </template>
        <!--course item actions-->
        <template v-slot:item.actions="{ item }">
            <!--edit button-->
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon small class="mr-2" @click="editItem(item)" v-bind="attrs" v-on="on">
                        mdi-pencil
                    </v-icon>
                </template>
                <span>Edit</span>
            </v-tooltip>

            <!--end edit button-->

            <!--delete section-->
            <v-dialog v-model="levelDeleteDialog" persistent max-width="400" :retain-focus="false">
                <!--retain-focus helps prevent from maximum exceeding error caused when two items are deleted continuously. this is a bug so add this props compulsarily-->
                <template v-slot:activator="{ on:dialog, attrs }">
                    <v-tooltip top>
                        <template v-slot:activator="{ on:tooltip }">
                            <v-icon small @click="levelDeleteDialog = true" v-bind="attrs" v-on="{...dialog,...tooltip}">
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Delete</span>
                    </v-tooltip>
                </template>
                <v-card>
                    <v-card-title class="headline">Delete Confirmation</v-card-title>
                    <v-card-text>Are you sure you want to delete this Exam Level?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="levelDeleteDialog = false">Cancel</v-btn>
                        <v-btn color="green darken-1" text @click="deleteItem(item)">Confirm</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!--end delete section-->

        </template>
        <!--end action-->
        <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
        </template>
    </v-data-table>
    <!--end course list-->

</v-container>
</template>

<script>
export default {
    data() {
        return {
            errLevelName: '',
            nameRules: [
                v => !!v || 'Exam Name is required',
                v => v.length <= 15 || "Max 15 characters",
            ],
            levelDialog: false,
            levelDeleteDialog: false,
            headers: [{
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'id',
                },
                {
                    text: 'Exam Name',
                    value: 'level_title'
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                },
            ],
            levels: [],
            editedIndex: -1,
            editedItem: {
                id: '',
                level_title: '',
            },
            defaultItem: {
                id: '',
                level_title: '',
            },
        }
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Category' : 'Edit Category Name'
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
            this.levels = []
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
            axios.get('/api/examLevel', {}).
            then(res => this.levels = res.data.levels)
                .catch(err => console.log(err.response))

        },

        editItem(item) {
            this.editedIndex = this.levels.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.levelDialog = true
        },

        deleteItem(item) {
            const index = this.levels.indexOf(item)
            this.levels.splice(index, 1)
            axios.delete('/api/examLevel/' + item.id)
                .then(this.levelDeleteDialog = false,
                    this.dataUpdateMsg = 'Exam Level deleted successfully',
                    this.dataUpdateAlert = true
                )
        },
        close() {
            this.levelDialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save() {
            if (this.editedIndex > -1) {
                axios.put('/api/examLevel/' + this.editedItem.id, {
                        'level_title': this.editedItem.level_title
                    })
                    .then(res => {
                        Object.assign(this.levels[this.editedIndex], res.data.levels),
                        this.close(),
                        this.dataUpdateMsg = 'Level Item updated successfully',
                        this.dataUpdateAlert = true

                    })
                    .catch(err => {
                        this.errLevelName = err.response.data.errors.level_title

                    })
                Object.assign(this.levels[this.editedIndex], this.editedItem)
            } else {
                axios.post('/api/examLevel', {
                        'level_title': this.editedItem.level_title,
                    })
                    .then(res => {
                        this.levels.push(res.data.levels),
                        this.close(),
                        this.dataUpdateMsg = 'New Level Added successfully',
                            this.dataUpdateAlert = true

                    }).catch(err => {

                        this.errLevelName =
                            err.response.data.errors.level_title

                    })
            }
        },
    },

}
</script>
