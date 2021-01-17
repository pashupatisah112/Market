<template>
    <div>
        <filterProduct></filterProduct>
        <collection></collection>
    </div>
</template>
<script>
import FilterProduct from '../Common/filter';
import Collection from './Collection';
export default {
    components:{
        FilterProduct,Collection
    },
    data(){
        return{
            
        }
    }
}
</script>