<template>
    <div>
        <filterProduct></filterProduct>
        <list></list>
    </div>
</template>
<script>
import FilterProduct from './filter';
import List from './List';
export default {
    components:{
        FilterProduct,List
    },
    data(){
        return{
            
        }
    }
}
</script>