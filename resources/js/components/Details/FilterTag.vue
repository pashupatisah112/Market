<template>
<div>
    <v-container>
        <v-row class="px-5">
            <v-col cols="12">
                <p class="font-weight-bold">Related Tags</p>
                <v-chip class="ma-2" v-for="item in tags.tag" :key="item.id">
                    {{item.tag_name}}
                </v-chip>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            tags: [],
            product_code: this.$route.params.code
        }
    },
    mounted() {
        this.getTags()
    },
    methods: {
        getTags() {
            axios.post('/api/getTags', {
                    code: this.product_code
                })
                .then(res => {
                    this.tags = res.data
                }).catch(err => console.log(err.response))
        }
    }
}
</script>
