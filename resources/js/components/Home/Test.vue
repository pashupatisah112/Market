<template>
    <div>
        <v-btn @click="login">facebook</v-btn>
    </div>
</template>
<script>
export default {
    data(){
        return{

        }
    },
    methods:{
        login(){
            axios.get('api/facebook/auth/redirect')
            .then(res=>console.log(res.data))
            .catch(err=>console.log(err.response))
        }
    }
}
</script>