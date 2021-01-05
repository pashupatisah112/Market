<template>
<!--Main profile dialog-->
<v-dialog v-model="dialog" persistent max-width="400">
    <template v-slot:activator="{ on, attrs }">
        <v-avatar size="30" v-bind="attrs" v-on="on">
            <v-img :src="getProfile()"></v-img>
        </v-avatar>
    </template>
    <v-card>
        <v-container>
            <v-row>
                <v-col cols="12" align-self="center">
                    <div class="profile pa-1 mx-auto">
                        <v-avatar size="93">
                            <v-img :src="getProfile()"></v-img>
                        </v-avatar>
                        <v-btn class="mt-n5" fab dark small color="primary" :loading="isSelecting" @click="onButtonClick" style="position:absolute;width:25px;height:25px">
                            <v-icon dark size="17">mdi-camera</v-icon>
                        </v-btn>
                        <input ref="uploader" class="d-none" type="file" accept="image/*" @change="onFileChanged">
                    </div>
                    <p class="text-center para-text main-color">Admin</p>
                    <p class="text-center mt-5 para-text mt-n5">{{this.admin.name}}</p>
                    <p class="text-center para-text mt-n5">{{this.admin.email}}</p>
                    <v-btn class="mx-auto btn-style white--text" rounded width="180" @click="updateInfoDialog=true">
                        Update Info
                    </v-btn>
                    <v-btn class="mx-auto btn-style white--text" rounded width="180" @click="changePasswordDialog=true">
                        Change Password
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="dialog = false">Close</v-btn>
        </v-card-actions>
    </v-card>

    <!--Profile changing dialog-->
    <v-dialog v-model="changeProfileDialog" max-width="350">
        <v-card>
            <v-card-title class="headline text-center">Updating Profie Picture</v-card-title>

            <div class="profile mx-auto pa-1">
                <v-avatar size="93">
                    <v-img v-if="url" :src="url"></v-img>
                    <v-img v-else src="../images/assets/avatar.png"></v-img>
                </v-avatar>
            </div>

            <v-card-actions>

                <v-btn color="green darken-1" text @click="changeProfileDialog = false">
                    cancel
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="updateProfile">
                    Confirm
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <!--End profile change dialog-->

    <!--Update info dialog-->
    <v-dialog v-model="updateInfoDialog" max-width="350">
        <v-card>
            <v-card-title class="headline text-center">Update Your Profile</v-card-title>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-form ref="form" v-model="valid" lazy-validation class="mt-n8">
                            <v-text-field v-model="name" :counter="25" :rules="nameRules" label="Name" required></v-text-field>

                            <v-text-field v-model="email" :rules="emailRules" label="E-mail" required :error-messages="errEmail"></v-text-field>

                            <v-card-actions>
                                <v-btn color="green darken-1" text @click="updateInfoDialog = false">
                                    cancel
                                </v-btn>
                                <v-spacer></v-spacer>
                                <v-btn color="green darken-1" text @click="updateInfo">
                                    Update
                                </v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-col>
                </v-row>
            </v-container>

        </v-card>
    </v-dialog>
    <!--end update info dialog-->

    <!--change password dialog-->
    <v-dialog v-model="changePasswordDialog" max-width="350" class="ma-3">
        <v-card>
            <p class="subtitle-text text-center mb-0">Change Password</p>

            <v-stepper v-model="e1" style="box-shadow:none">
                <v-stepper-items>
                    <v-stepper-content step="1">
                        <v-form ref="form" v-model="valid" lazy-validation>

                            <v-text-field label="Enter Your Password" solo single-line dense v-model="oldPassword" :error-messages="errPassword" class="input-style mb-n1" :type="show1? 'text': 'password'" :append-icon="show1? 'mdi-eye': 'mdi-eye-off'" @click:append="show1 = !show1" :rules="[rules.required,rules.length,rules.case,rules.number]" prepend-inner-icon="mdi-lock"></v-text-field>

                            <v-btn color="primary" rounded class="btn-style-no-shadow float-left mb-5" @click="changePasswordDialog=false">
                                Cancel
                            </v-btn>
                            <v-btn color="primary" rounded class="btn-style-no-shadow float-right mb-5" :disabled="!valid" @click="checkPassword">
                                Confirm
                            </v-btn>
                        </v-form>
                    </v-stepper-content>
                    <v-stepper-content step="2">
                        <v-form ref="form" v-model="valid" lazy-validation>
                            <v-text-field label="New Password" solo single-line dense v-model="newPassword" class="input-style mb-n1" :type="show1? 'text': 'password'" :append-icon="show1? 'mdi-eye': 'mdi-eye-off'" @click:append="show1 = !show1" :rules="[rules.required,rules.length,rules.case,rules.number]" prepend-inner-icon="mdi-lock"></v-text-field>

                            <v-text-field label="Confirm New Password" solo single-line dense v-model="confirmNewPassword" class="input-style mb-n1" :type="show1 ? 'text' : 'password'" :rules="[rules.required,rules.confirm]" prepend-inner-icon="mdi-lock"></v-text-field>

                            <v-btn color="primary" rounded class="btn-style float-left mb-5" @click="e1=1">
                                Cancel
                            </v-btn>
                            <v-btn color="primary" rounded class="btn-style float-right mb-5" :disabled="!valid" @click="changePassword">
                                change
                            </v-btn>
                        </v-form>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>

        </v-card>
    </v-dialog>
    <!--end change password dialog-->

</v-dialog>
<!--End main profile dialog-->
</template>

<script>
export default {
    data() {
        return {
            changeProfileDialog: false,
            updateInfoDialog: false,
            changePasswordDialog: false,
            e1: 1,
            errPassword: '',
            errEmail: '',
            show1: false,
            oldPassword: '',
            newPassword: '',
            confirmNewPassword: '',
            selectedFile: null,
            isSelecting: false,
            url: null,
            admin: '',
            valid: true,
            dialog: false,
            name: '',
            rules: {
                required: value => !!value || "Required.",
                length: v => v.length >= 8 || "Min 8 characters",
                case: v => /(?=.*[A-Z])/.test(v) || 'Must have one uppercase',
                number: v => /(?=.*\d)/.test(v) || 'Must have one number',
                confirm: v => this.password == this.confirm_password || "Password must match",
            },
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 25) || 'Name must be less than 25 characters',
            ],
            email: '',
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
        }
    },
    mounted() {
        axios.get('api/getCurrentUser', {})
            .then(res => {
                this.admin = res.data.auth_user[0]
                this.name = this.admin.name
                this.email = this.admin.email
            }).catch(err => {
                console.log(err.response)
            })
    },
    methods: {
        onButtonClick() {
            this.isSelecting = true
            window.addEventListener('focus', () => {
                this.isSelecting = false
            }, {
                once: true
            })

            this.$refs.uploader.click()
        },
        onFileChanged(e) {
            console.log(e.target.files[0]);
            const file = e.target.files[0];
            this.selectedFile = e.target.files[0];
            this.url = URL.createObjectURL(file);
            this.changeProfileDialog = true;
        },
        updateProfile() {
            this.changeProfileDialog = false
            let data = new FormData()
            data.append('selectedFile', this.selectedFile, this.selectedFile.name)
            data.append('id', this.admin.profile)
            let settings = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            axios.post('api/updateProfile', data, settings)
                .then(res => {
                    this.admin = res.data
                    console.log(res.data)
                }).catch(err => {
                    console.log(err.response)
                });

            this.changeProfileDialog = false

        },
        getProfile() {
            return "../storage/" + this.admin.profile;
            /*
            database was saving public/profile/filename so in config/filesystems
            'root' => storage_path('app'),
             changed to
             'root' => storage_path('app/public'),
             now it is saved as profile/filename makes easier to hit the path
             now we can give actual path with "../storage/"" as above. this hits storage folder 
             inside main public folder and of course we should run php artisan storage:link
            */
        },
        updateInfo() {
            axios.put('api/updateInfo/' + this.admin.id, {
                    'name': this.name,
                    'email': this.email
                })
                .then(res => {
                    this.admin = res.data.token
                    this.updateInfoDialog = false;
                }).catch(err => {
                    this.errEmail = err.response.data.errors.email
                });

        },
        checkPassword() {
            axios.post('api/checkPassword', {
                    'id': this.admin.id,
                    'name': this.oldPassword,
                })
                .then(res => {
                    console.log(res.data)
                    //e1=2
                }).catch(err => {
                    this.errPassword = 'Password does not match'
                    this.$refs.form.resetValidation()
                });
        },
        changePassword() {

        },
        validate() {
            this.$refs.form.validate()
        },
    }
}
</script>

<style scoped>
.profile {
    width: 100px;
    height: 100px;
    border-radius: 50px;
    background-color: white;
}

div.v-stepper__wrapper {
    padding: 20px;
}
</style>
