<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import MainButton from '@/Components/Buttons/MainButton.vue';
import SideCategories from '@/Components/SideCategories.vue';
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
    featured: {
        type: Array,
        default: () => [],
    },
    sliders: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <AppLayout title="Welcome">

        <div class="container mx-auto px-4 py-4 flex flex-col sm:flex-row">
            <div class="w-1/5 py-4">
                <SideCategories :categories="categories" />
            </div>
            <div class="w-4/5 mx-auto">
                <Carousel>
                    <Slide v-for="(slider, index) in sliders" :key="index" :autoplay="2000" :wrap-around="true">
                        <img :src="'/storage/' + slider.image" alt="the shop store" class="w-full h-96 opacity-75 object-cover">
                    </Slide>

                    <template #addons>
                        <Pagination />
                    </template>
                </Carousel>
            </div>


        </div>
        <!-- <div class="text-center border-t border-b py-4">
            <p>Lorem ipsum dolor sit amet.</p>
        </div> -->
        <div class="flex flex-col max-w-7xl mx-auto px-4 sm:container sm:flex-row sm:space-x-4 sm:my-4 sm:px-6 lg:px-8">
            <Link :href="route('shop.show', feat.slug)" class="flex flex-col w-full h-full mb-4" v-for="(feat, index) in featured" :key="index">
                <div class="text-center text-white bg-gray-700 py-2">
                    <span>
                        {{ feat.name }}
                    </span>
                </div>
                <img :src="'/storage/' + feat.main_image" :alt="feat.name" class="h-72 object-cover md:w-72 lg:w-96">
            </Link>
        </div>
        <div class="text-center text-white bg-black px-4 py-4">
            <p class="container">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iusto fuga neque culpa illum sit exercitationem enim dolores dolor quaerat quos, ex ipsa, recusandae in ad voluptates officia voluptatem, nobis animi!
                Magni harum quos voluptas ex eveniet inventore rerum ducimus repellendus! Saepe, nam. Tempora optio ratione ipsa. Commodi est voluptatem excepturi dignissimos voluptas nostrum ut atque, repellendus quidem nesciunt, maiores fugiat?
                Esse eligendi amet quo error, nostrum necessitatibus laudantium nulla rem quidem accusantium tenetur, aperiam qui excepturi! Natus, praesentium repellat esse optio fugiat id vel voluptatum deserunt minus, provident cum doloribus.
            </p>
        </div>
    </AppLayout>
</template>

<style scoped>
    .carousel__item {
        min-height: 200px;
        width: 100%;
        background-color: var(--vc-clr-primary);
        color: var(--vc-clr-white);
        font-size: 20px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .carousel__slide {
        padding: 10px;
    }
</style>
