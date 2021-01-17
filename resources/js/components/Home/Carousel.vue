<template>
<v-carousel cycle class="mt-2">
    <v-carousel-item :show-arrows="arrows" v-for="(item,i) in items" :key="i" :src="item.src" reverse-transition="fade-transition" transition="fade-transition">
        <v-card color="transparent" max-width="500" flat style="position:absolute;left:5%;bottom:20%">
            <v-card-subtitle class="mb-n8 text-h6">NEW ARRIVALS</v-card-subtitle>
            <v-card-title class="text-h3">DENIM JACKETS</v-card-title>
            <v-card-text>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incident ut
              labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus viverra maeceans 
              accumsons lacus vel facilisis.
            </v-card-text>
            <v-card-actions>
                <v-btn rounded outlined dark width="150" class="text-capitalize">Discover More</v-btn>
                <v-btn rounded dark width="150" class="text-capitalize">Add to cart</v-btn>
            </v-card-actions>
        </v-card>
    </v-carousel-item>
</v-carousel>
</template>

<script>
export default {
    data() {
        return {
          arrows:false,
            items: [{
                    src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
                },
                {
                    src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
                },
            ],
        }
    },
}
</script>
