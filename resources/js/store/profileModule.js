export default {
    state: {
        profileDetails:''
    },
    mutations: {
        //using this makes a data reactive
        changeProfileInfo(state,payload){
            this.state.profileDetails=payload
        }
    },
    actions: {

    },
    getters: {}
};
