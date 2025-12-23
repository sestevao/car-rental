<script setup>
import { Head, Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    featuredCars: Array,
});
</script>

<template>
    <Head title="Welcome" />

    <FrontendLayout>
        <!-- Hero Section -->
        <div class="relative bg-white dark:bg-gray-900 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white dark:bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Drive your dreams</span>
                                <span class="block text-indigo-600 dark:text-indigo-400 xl:inline"> today</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Premium car rental service. Choose from our wide range of luxury and comfort vehicles for your next journey.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <Link :href="route('frontend.cars.index')" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                        Browse Cars
                                    </Link>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <Link v-if="!$page.props.auth.user" :href="route('register')" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:bg-gray-800 dark:text-indigo-400 dark:hover:bg-gray-700 md:py-4 md:text-lg md:px-10">
                                        Sign Up
                                    </Link>
                                    <Link v-else :href="route('dashboard')" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:bg-gray-800 dark:text-indigo-400 dark:hover:bg-gray-700 md:py-4 md:text-lg md:px-10">
                                        Dashboard
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80" alt="Luxury Car">
            </div>
        </div>

        <!-- Featured Cars Section -->
        <div class="bg-gray-100 dark:bg-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Featured Vehicles
                    </h2>
                    <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400 sm:mt-4">
                        Check out our latest additions to the fleet.
                    </p>
                </div>
                
                <div class="mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
                    <div v-for="car in featuredCars" :key="car.id" class="flex flex-col rounded-lg shadow-lg overflow-hidden bg-white dark:bg-gray-900">
                        <div class="flex-shrink-0">
                            <img class="h-48 w-full object-cover" :src="car.image_url || 'https://via.placeholder.com/400x300'" :alt="car.make + ' ' + car.model">
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                    {{ car.year }}
                                </p>
                                <div class="block mt-2">
                                    <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ car.make }} {{ car.model }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                                        £{{ car.price_per_day }} / day
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center">
                                <Link :href="route('frontend.cars.show', car.id)" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                    View Details
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 text-center" v-if="featuredCars.length === 0">
                    <p class="text-gray-500 dark:text-gray-400">No cars available at the moment.</p>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>