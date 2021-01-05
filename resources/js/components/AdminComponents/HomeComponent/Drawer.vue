<template>
    <div>
        <v-navigation-drawer app id="core-navigation-drawer" color="background" :expand-on-hover="expandOnHover" :mini-variant="miniVariant" :right="right" absolute dark width="240px">
            <v-list dense nav class="py-0">
                <v-list-item two-line :class="miniVariant && 'px-0'">
                        <v-img src="../images/assets/logo.png"></v-img>
                </v-list-item>

                <v-divider></v-divider>

                <v-list-item v-for="item in items" :key="item.title" :to="item.to" link>
                    <v-list-item-icon>
                        <v-icon style="color:#777777">{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title style="color:#777777">{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>
<script>
export default {
    data() {
        return {
            drawer: true,
            items: [{
                    title: 'Dashboard',
                    icon: 'mdi-view-dashboard',
                    to: '/admin/dashboard',
                },
                {
                    title: 'Roles',
                    icon: 'mdi-account-star',
                    to: '/admin/roles'
                },
                {
                    title: 'Content',
                    icon: 'mdi-folder',
                    to: '/admin/content'
                },
                {
                    title: 'Courses',
                    icon: 'mdi-table-of-contents',
                    to: '/admin/courses'
                },
                {
                    title: 'Exams and Sets',
                    icon: 'mdi-file-question',
                    to: '/admin/exams-and-sets'
                },
                {
                    title: 'Staffs',
                    icon: 'mdi-account-group',
                    to: '/admin/staffs'
                },
                {
                    title: 'Tutors',
                    icon: 'mdi-teach',
                    to: '/admin/tutors'
                },
                {
                    title: 'Students',
                    icon: 'mdi-school',
                    to: '/admin/students'
                },
                {
                    title: 'Organization',
                    icon: 'mdi-office-building',
                    to: '/admin/organizations'
                },
                {
                    title: 'Notices',
                    icon: 'mdi-note',
                    to: '/admin/notices'
                },
                {
                    title: 'Results',
                    icon: 'mdi-publish',
                    to: '/admin/results'
                },
                {
                    title: 'Advertisements',
                    icon: 'mdi-google-ads',
                    to: '/admin/ads'
                },
                {
                    title: 'Requests',
                    icon: 'mdi-frequently-asked-questions',
                    to: '/admin/requests'
                },
                {
                    title: 'Complaints',
                    icon: 'mdi-emoticon-angry',
                    to: '/admin/complaints'
                },
            ],
            color: 'primary',
            right:false,
            miniVariant: false,
            expandOnHover: false,
        }
    },
}
</script>