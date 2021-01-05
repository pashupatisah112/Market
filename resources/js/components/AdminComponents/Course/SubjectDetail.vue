<template>
<div>
  <v-card>
    <v-tabs
      v-model="tab"
      background-color="success"
      centered
      dark
      icons-and-text
    >
      <v-tabs-slider></v-tabs-slider>

      <v-tab href="#tab-1">
        Notes
        <v-icon>mdi-notebook</v-icon>
      </v-tab>

      <v-tab href="#tab-2">
        Videos
        <v-icon>mdi-video</v-icon>
      </v-tab>

      <v-tab href="#tab-3">
        Questions
        <v-icon>mdi-head-question</v-icon>
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="i in 3"
        :key="i"
        :value="'tab-' + i"
      >
        <v-card flat>
          <v-card-text>{{ text }}</v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</div>
</template>
<script>
  export default {
    data () {
      return {
        tab: null,
        notes:[],
      }
    },
    computed: {
        subject_id() {
            return this.$route.params.id  //returns value set in route params
        },
    },
    methods: {
        initialize() {
            this.subjects = []
            axios.interceptors.request.use((config) => {
                this.loading = true;
                return config;
            }, (error) => {
                this.loading = false;
                return Promise.reject(error);
            });

            axios.interceptors.response.use((response) => {
                this.loading = false;
                return response;
            }, (error) => {
                this.loading = false;
                return Promise.reject(error);
            });
            axios.get('/api/course/subject/notes', {params:{id:this.course_id}}).
            then(res => this.subjects=res.data.mbbs_subjects)
                .catch(err => console.log(err.response))

        },
    }
  }
</script>


