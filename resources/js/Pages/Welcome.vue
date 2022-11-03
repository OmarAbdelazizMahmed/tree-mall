<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import MainButton from '@/Components/Buttons/MainButton.vue';
import SideCategories from '@/Components/SideCategories.vue';
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import { ref } from '@vue/reactivity';

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
    topSelling: {
        type: Array,
        default: () => [],
    },
});

const currentSlide = ref(0);
// method to change slide
const slideTo = (index) => {
    currentSlide.value = index;
};

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
        <!-- top selling products -->
        <div class="flex flex-col max-w-7xl mx-auto px-4 sm:container sm:flex-row sm:space-x-4 sm:my-4 sm:px-6 lg:px-8">
            <div class="w-full">
                <h1 class="text-2xl font-bold text-gray-900 bg-amber-100 p-4">Top Selling Products</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div v-for="(product, index) in topSelling" :key="index" class="w-full">
                        <div class="bg-white shadow-md rounded-md overflow-hidden">
                            <div class="w-full h-64">
                                <img :src="'/storage/' + product.main_image" alt="product image" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h1 class="text-lg font-bold text-gray-900">{{ product.name }}</h1>
                                <p class="text-gray-600 text-sm">{{ product.description }}</p>
                                <p class="text-gray-600 text-sm">{{ product.price }}</p>
                                <MainButton class="w-full mt-4" :href="route('shop.show', product.slug)">View Product</MainButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- featured products would be a carousel -->
        <!-- <div class="flex flex-col max-w-7xl mx-auto px-4 sm:container sm:flex-row sm:space-x-4 sm:my-4 sm:px-6 lg:px-8">
            <div class="w-full">
                <h1 class="text-2xl font-bold text-gray-900 bg-amber-100 p-4">Featured Products</h1>
                    <Carousel id="gallery" :items-to-show="1" :wrap-around="false" v-model="currentSlide" class="w-full h-96">
                        <Slide v-for="(product, index) in featured" :key="index" :autoplay="2000" :wrap-around="true" class="w-full carousel__item bg-white shadow-md rounded-md overflow-hidden object-cover">
                            <div class="rounded-md overflow-hidden">
                                <div class="w-full h-64">
                                    <Link :href="route('shop.show', product.slug)">
                                        <img :src="'/storage/' + product.main_image" alt="product image" class="w-full h-80 object-cover carousel__item">
                                    </Link>
                                </div>
                            </div>
                        </Slide>
                    </Carousel>

                    <Carousel
                        id="thumbnails"
                        :items-to-show="4"
                        :wrap-around="true"
                        v-model="currentSlide"
                        ref="carousel"
                    >
                        <Slide v-for="(product, index) in featured" :key="index">
                            <div class="carousel__item">
                                <img :src="'/storage/' + product.main_image" alt="product image" class="w-full h-full object-cover">
                            </div>
                        </Slide>
                    </Carousel>

            </div>
        </div> -->
        <div class="flex flex-col max-w-7xl mx-auto px-4 sm:container sm:flex-row sm:space-x-4 sm:my-4 sm:px-6 lg:px-8">
            <div class="w-full">

            <h1 class="text-2xl font-bold text-gray-900 bg-amber-100 p-4">Featured Products</h1>
            <Carousel id="gallery" :items-to-show="1" :wrap-around="false" v-model="currentSlide">
                <Slide v-for="(product, index) in featured" :key="index">
                    <Link :href="route('shop.show', product.slug)" class="w-full h-96">
                        <img :src="'/storage/' + product.main_image" alt="product image" class="h-96 w-full object-fill">
                    </Link>
                <!-- <div class="carousel__item bg-white shadow-md rounded-md overflow-hidden object-cover"> -->
                    <!-- <img :src="'/storage/' + product.main_image" alt="product image" class="object-cover"> -->
                <!-- </div> -->
                </Slide>
            </Carousel>

            <Carousel
                id="thumbnails"
                :items-to-show="4"
                :wrap-around="true"
                v-model="currentSlide"
                ref="carousel"
            >
                <Slide v-for="(product, index) in featured" :key="index">
                    <!-- <div class="carousel__item"> -->
                        <img :src="'/storage/' + product.main_image" alt="product image" class="w-full h-full object-cover">
                    <!-- </div> -->
                </Slide>
            </Carousel>
            </div>
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
