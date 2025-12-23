<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const showingNavigationDropdown = ref(false);
const user = usePage().props.auth.user;
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('home')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <Link :href="route('home')" :active="route().current('home')" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 transition duration-150 ease-in-out" :class="{ '!border-indigo-400 dark:!border-indigo-600 !text-gray-900 dark:!text-gray-100': route().current('home') }">
                                Home
                            </Link>
                            <Link :href="route('frontend.cars.index')" :active="route().current('frontend.cars.index')" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 transition duration-150 ease-in-out" :class="{ '!border-indigo-400 dark:!border-indigo-600 !text-gray-900 dark:!text-gray-100': route().current('frontend.cars.*') }">
                                Browse Cars
                            </Link>
                            <Link v-if="user" :href="route('my-bookings')" :active="route().current('my-bookings')" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 transition duration-150 ease-in-out" :class="{ '!border-indigo-400 dark:!border-indigo-600 !text-gray-900 dark:!text-gray-100': route().current('my-bookings') }">
                                My Bookings
                            </Link>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div v-if="user" class="ms-3 relative">
                            <Link :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-300 underline">
                                Dashboard
                            </Link>
                        </div>
                        <div v-else class="space-x-4">
                            <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Log in</Link>
                            <Link :href="route('register')" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Register</Link>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                class="sm:hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <Link :href="route('home')" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150 ease-in-out" :class="{ '!border-indigo-400 dark:!border-indigo-600 !text-indigo-700 dark:!text-indigo-300 !bg-indigo-50 dark:!bg-indigo-900/50': route().current('home') }">
                        Home
                    </Link>
                    <Link :href="route('frontend.cars.index')" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150 ease-in-out" :class="{ '!border-indigo-400 dark:!border-indigo-600 !text-indigo-700 dark:!text-indigo-300 !bg-indigo-50 dark:!bg-indigo-900/50': route().current('frontend.cars.*') }">
                        Browse Cars
                    </Link>
                    <Link v-if="user" :href="route('my-bookings')" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150 ease-in-out" :class="{ '!border-indigo-400 dark:!border-indigo-600 !text-indigo-700 dark:!text-indigo-300 !bg-indigo-50 dark:!bg-indigo-900/50': route().current('my-bookings') }">
                        My Bookings
                    </Link>
                </div>

                <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div v-if="user" class="px-4">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                            {{ user.name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">{{ user.email }}</div>
                        <div class="mt-3 space-y-1">
                            <Link :href="route('dashboard')" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150 ease-in-out">
                                Dashboard
                            </Link>
                        </div>
                    </div>
                    <div v-else class="px-4 space-y-1">
                        <Link :href="route('login')" class="block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-gray-600 dark:text-gray-400">Log in</Link>
                        <Link :href="route('register')" class="block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-gray-600 dark:text-gray-400">Register</Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
        
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ new Date().getFullYear() }} Car Rental System. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>