<template>
<div>
    <v-container fluid>
        <v-row>
            <div class="mt-n10">
                <v-breadcrumbs :items="breadItems"></v-breadcrumbs>
            </div>
        </v-row>
        <v-row>
            <p class="subtitle-text head-color">Manage Your Web Content</p>
        </v-row>
        <v-row>
            <v-col cols="12" lg="4">
                <v-card class="mx-auto" max-width="400">
                    <v-img class="white--text align-end" height="200px" src="../images/assets/homepage.png">
                    </v-img>
                    <v-card-actions>
                        <v-card-title class="main-color">Home Content</v-card-title>

                        <v-btn color="orange" text to="/admin/content/homepage">
                            Manage
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
export default {
    data() {
        return {
            breadItems: [{
                text: "Dashboard",
                disabled: false,
                href: "/#/admin/dashboard"
            },
            {
                text: "Content",
                disabled: true,
                href: ""
            }
        ],
        }
    }
}
</script>
