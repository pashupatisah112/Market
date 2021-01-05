<template>
<div>
    <v-containe fluid class="backgroundImage">

    </v-containe>
</div>
</template>

<script>

export default {
    data() {
        return {
            
        }
    },
    computed: {
        
        
    },
    methods: {

        submit(){
            if(this.$refs.form.validate()){
                this.adminLogin()
            }
        }
    }
}
</script>
