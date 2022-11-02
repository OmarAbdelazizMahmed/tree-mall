<template>
    <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <Link :href="route('welcome')" class="font-logo block w-auto hover:text-yellow-500 transition">
                            Tree Mall
                        </Link>
                    </div>
                </div>
                <!--  add search auto search -->
                <div class="flex items-center w-1/2">
                    <AutoComplete></AutoComplete>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <div class="flex items-center space-x-3 relative">
                            <Link :href="route('dashboard')" class="hover:text-yellow-500 transition"
                                v-if="$page.props.user">
                            Dashboard
                            </Link>
                            <template v-else>

                                <div class="relative inline-block text-left">
                                    <div>
                                        <button type="button" class="inline-flex justify-center w-full rounded-md px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex flex-row" id="options-menu" aria-haspopup="true" aria-expanded="true" @click="open = !open">
                                            <icon name="user" class="mr-2 w-4 h-4"></icon>
                                            Account
                                            <!-- Heroicon name: solid/chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="origin-top right-0 absolute mt-2 w-56 rounded-md shadow-lg bg-white focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" v-show="open">
                                        <div class="py-1" role="none">
                                            <Link :href="route('register')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Register</Link>
                                            <Link :href="route('login')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Login</Link>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <form method="POST" @submit.prevent="logout" v-if="$page.props.user">
                                <button type="submit" class="hover:text-yellow-500 transition">
                                    Log Out
                                </button>
                            </form>
                            <Link :href="route('cart.index')" class="hover:text-amber-700 transition">
                            <span class="bg-red-600 text-white text-xs rounded-md p-1 absolute"
                                style="top: -10px; right: -8px;" v-if="$page.props.cartCount > 0">
                                {{ $page . props . cartCount }}
                            </span>
                            <icon name="cart" class="w-4 h-4 fill-current"></icon>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button id="hamburger" @click="showingNavigationDropdown = ! showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path
                                :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->

        <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }" class="sm:hidden">
            <template v-if="$page.props.user">
                <div class="pt-2 pb-3 space-y-1">
                    <JetResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </JetResponsiveNavLink>
                </div>
            </template>
            <template v-else>
                <div class="pt-2 pb-3 space-y-1">
                    <JetResponsiveNavLink :href="route('register')">
                        Register
                    </JetResponsiveNavLink>
                </div>
                <div class="pt-2 pb-3 space-y-1">
                    <JetResponsiveNavLink :href="route('login')">
                        Login
                    </JetResponsiveNavLink>
                </div>
            </template>
            <div class="pt-2 pb-3 space-y-1">
                <JetResponsiveNavLink :href="route('shop.index')">
                    Shop
                </JetResponsiveNavLink>
            </div>
            <div class="pt-2 pb-3 space-y-1" v-if="$page.props.cartCount > 0">
                <Link :href="route('cart.index')"
                    class="flex items-center pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-red-700 hover:border-red-700 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition">
                <icon name="cart" class="w-4 h-4 text-red-700 fill-current"></icon>
                <span class="ml-2">
                    {{ $page . props . cartCount }} item(s) in cart
                </span>
                </Link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200" v-if="$page.props.user">
                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" @submit.prevent="logout">
                        <JetResponsiveNavLink as="button">
                            Log Out
                        </JetResponsiveNavLink>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AutoComplete from '@/Components/Search/AutoComplete.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Components/ApplicationMark.vue';
import JetDropdown from '@/Components/Dropdown.vue';
import JetDropdownLink from '@/Components/DropdownLink.vue';
import JetNavLink from '@/Components/NavLink.vue';
import JetResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';



const showingNavigationDropdown = ref(false);


const logout = () => {
    Inertia.post(route('logout'));
};
// def open property
const open = ref(false);

</script>

