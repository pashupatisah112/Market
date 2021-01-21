import router from "../router";
export default {
    state: {
       auth:null,
       loginDialog:false,
       token:false,
    },
    mutations: {
        
    },
    actions: {
        logout: function () {
            localStorage.removeItem('token');
            router.push('/adminLogin').then(res => console.log('Logged out')).catch(err => console.log(err));
        },
    },
    getters: {
        
    }
};
