<template>
    <div class="bg-white text-center py-4">
        <span class="text-xl font-bold">Categories</span>
        <div class="flex flex-col divide-y">
        <Link
            :href="route('shop.index', { category: category.slug })"
            class="text-left px-4 py-4 transition hover:text-white hover:bg-amber-500 sm:px-6 lg:px-8"
            :class="route().current('shop.index', { category: category.slug}) ? 'bg-amber-500 text-white' : ''"
            v-for="(category, index) in categories"
            :key="index"
        >
            {{ category.name }}
        </Link>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: {
        categories: {
            type: Array,
            default: () => [],
        },
    },
    components: {
        Link,
    },
};


</script>
