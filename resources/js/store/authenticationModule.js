import router from "../router";
export default {
    state: {
       loginDialog:false,
       termsDialog:false,
       forgotPasswordDialog:false,
       token:false,
       auth:[]
    },
    mutations: {
        setLoginDialog(state){
            state.loginDialog=true
        },
        unsetLoginDialog(state){
            state.loginDialog=false
        },
        setForgotPasswordDialog(state){
            state.forgotPasswordDialog=true
        },
        unsetForgotPasswordDialog(state){
            state.forgotPasswordDialog=false
        },
        setAuth(state,item){
            state.auth=item
        },
        setToken(state){
            state.token=true
        }
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
