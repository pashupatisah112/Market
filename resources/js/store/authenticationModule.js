import router from "../router";
export default {
    state: {
       
    },
    mutations: {
        
    },
    actions: {
        logout: function () {
            localStorage.removeItem('token');
            router.push('/login').then(res => console.log('Logged out')).catch(err => console.log(err));
        },
        getMateRequest(){

        }
    },
    getters: {
        get_auth(state){
        }
    }
};
