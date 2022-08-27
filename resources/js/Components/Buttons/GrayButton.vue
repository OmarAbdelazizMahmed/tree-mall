<template>
    <Link :href="href" :class="classes" v-if="like === 'href'">
        <slot></slot>
    </Link>
    <button :class="classes" v-else>
        <slot></slot>
    </button>
</template>
<script setup>
    import { defineComponent } from "vue";
    import { Link } from '@inertiajs/inertia-vue3'

    defineProps({
        href: String,
        active: Boolean,
        like: String,
    });

    const classes = computed(() => {
        return 'justify-center inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 transition';
    })
</script>
