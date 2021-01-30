import router from "../router";
export default {
    state: {
       auth:null,
       loginDialog:false,
       userToken:false,
    },
    mutations: {
        
    },
    actions: {
        // logout: function () {
        //     localStorage.removeItem('userToken');
        //     router.push('/adminLogin').then(res => console.log('Logged out')).catch(err => console.log(err));
        // },
    },
    getters: {
        
    }
};
