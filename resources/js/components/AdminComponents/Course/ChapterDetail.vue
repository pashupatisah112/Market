<template>
<div>
    <v-row>
        <v-icon color="black" @click="goBack">mdi-arrow-left-bold</v-icon>
    </v-row>
    
    <v-card>
        <v-toolbar flat color="primary" dark>
            <v-toolbar-title>Chapter Name</v-toolbar-title>
        </v-toolbar>
        <v-tabs vertical>
            <v-tab>
                <v-icon left>mdi-notebook</v-icon>
                Note
            </v-tab>
            <v-tab>
                <v-icon left>mdi-video</v-icon>
                Videos
            </v-tab>
            <v-tab>
                <v-icon left>mdi-head-question-outline</v-icon>
                Questions
            </v-tab>

            <!----Datatable for notes---->
            <v-tab-item>
                <notes></notes>
            </v-tab-item>

            <!---------datatable for videos------------>
            <v-tab-item>
                <videos></videos>
            </v-tab-item>

            <!---------data table for questions----------->
            <v-tab-item>
                <questions></questions>
            </v-tab-item>
        </v-tabs>
    </v-card>
</div>
</template>

<script>
import Notes from './Notes';
import Videos from './Videos';
import Questions from './Questions';
export default {
    components: {
        Notes,
        Videos,
        Questions
    },
    data: () => ({
        tab: null,
         
    }),
    methods:{
        goBack() {
            window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
        }
    }
};
</script>
