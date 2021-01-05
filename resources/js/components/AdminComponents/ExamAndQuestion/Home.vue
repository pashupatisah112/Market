<template>
    <div>
        <v-container>
            <v-row>
                <v-col cols="6">
                    <exam></exam>
                </v-col>
                <v-col cols="6">
                    <examLevel></examLevel>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <mcqSet></mcqSet>
                </v-col>
            </v-row>
        </v-container>

        <!--snackbar for data update message-->
    <v-snackbar v-model="dataUpdateAlert" :color="alertColor" :timeout="timeout">
        <v-icon color="white" style="margin-right:10px">mdi-checkbox-marked-circle</v-icon>
        {{dataUpdateMsg}}
        <v-btn color="white" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
    <!--end snackbar-->
    </div>
</template>
<script>
import Exam from './Exam';
import ExamLevel from './ExamLevel';
import McqSet from './McqSet';
import Question from './Questions';
export default {
    components:{Exam,ExamLevel,McqSet,Question},
    data(){
        return{
            dataUpdateMsg: '',
            dataUpdateAlert:false,
            alertColor: 'success',
            timeout: 2000,
        }
    }
}
</script>