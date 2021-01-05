<template>
<div>
    <v-container fluid>
        <div class="mt-n10">
            <v-breadcrumbs :items="breadItems"></v-breadcrumbs>
        </div>

        <overview></overview>

        <list></list>
    </v-container>
</div>
</template>

<script>
import Overview from './CourseOverview';
import List from './CourseList';
export default {
    components:{Overview,List},
    data() {
        return {
           breadItems: [{
                text: "Dashboard",
                disabled: false,
                href: "/#/admin/dashboard"
            },
            {
                text: "Course",
                disabled: true,
                href: ""
            }
        ],
        }
    }
}
</script>
