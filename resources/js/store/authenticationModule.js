import router from "../router";
export default {
    state: {
       auth:null
    },
    mutations: {
        
    },
    actions: {
        logout: function () {
            localStorage.removeItem('admin_token');
            router.push('/adminLogin').then(res => console.log('Logged out')).catch(err => console.log(err));
        },
    },
    getters: {
        get_auth(state){
        }
    }
};
