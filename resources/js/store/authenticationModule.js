import router from "../router";
export default {
    state: {
       
    },
    mutations: {
        
    },
    actions: {
        adminLogin() {
            axios
                .post("/api/admin-login", {
                    email: this.state.adminLoginEmail,
                    password: this.state.adminLoginPassword,
                    role_id: 1
                })
                .then(res => {
                    localStorage.setItem("token", res.data.token);
                    localStorage.setItem("loggedIn", true); //to load snackbar of home only once when logged in
                    router
                        .push("/admin/dashboard") //this.$router.push() when used inside app
                        .catch(err => console.log(err));
                })
                .catch(err => {
                    this.state.snackMessage = err.response.data.status;
                    this.state.snackbar = true;
                });
        },
        logout: function () {
            localStorage.removeItem('token');
            router.push('/login').then(res => console.log('Logged out')).catch(err => console.log(err));
        },
        getProfile() {
            return "../storage/" + this.state.auth.profile;
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
        
        getMateRequest(){

        }
    },
    getters: {
        get_auth(state){
        }
    }
};
