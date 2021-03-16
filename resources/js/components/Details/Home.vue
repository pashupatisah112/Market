<template>
<div>
    <v-container fluid>
        <v-row>
            <v-col cols="12" lg="8" md="8">
                <detail></detail>

                <v-divider></v-divider>

                <tag></tag>

                <v-divider></v-divider>

                <suggestion></suggestion>
            </v-col>
            <v-col cols="12" lg="4" md="4">
                <p class="font-weight-bold">{{$t('words.detail.ratingReviews')}}</p>

                <rating></rating>

                <v-divider></v-divider>

                <comment></comment>

            </v-col>
        </v-row>
    </v-container>

</div>
</template>

<script>
import Detail from './Detail';
import Suggestion from './Suggestion';
import Rating from './Rating';
import Comment from './Comment';
import Tag from './FilterTag';
export default {
    components: {
        Detail,
        Suggestion,
        Rating,
        Comment,
        Tag
    },
    data() {
        return {

        }
    }
}
</script>
