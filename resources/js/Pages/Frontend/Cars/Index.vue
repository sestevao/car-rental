<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    cars: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');

watch(search, debounce((value) => {
    router.get(route('frontend.cars.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));
</script>

<template>
    <Head title="Browse Cars" />

    <FrontendLayout>
        <div class="bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">Our Fleet</h1>
                    
                    <div class="mt-4 sm:mt-0 relative rounded-md shadow-sm">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search cars..."
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-4 sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                        />
                    </div>
                </div>

                <div class="mt-10 grid gap-10 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="car in cars.data" :key="car.id" class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                        <div class="aspect-w-3 aspect-h-2 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-64">
                            <img :src="car.image_url || 'https://via.placeholder.com/400x300'" :alt="car.make + ' ' + car.model" class="h-full w-full object-cover object-center sm:h-full sm:w-full" />
                        </div>
                        <div class="flex flex-1 flex-col p-6 space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                        <Link :href="route('frontend.cars.show', car.id)">
                                            <span aria-hidden="true" class="absolute inset-0" />
                                            {{ car.make }} {{ car.model }}
                                        </Link>
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ car.year }}</p>
                                </div>
                                <p class="text-lg font-medium text-indigo-600 dark:text-indigo-400">£{{ car.price_per_day }}<span class="text-sm text-gray-500 dark:text-gray-400">/day</span></p>
                            </div>
                            
                            <!-- Badges/Features could go here -->
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span v-if="car.transmission" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ car.transmission }}
                                </span>
                                <span v-if="car.seats" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ car.seats }} Seats
                                </span>
                            </div>

                            <div class="flex-1"></div> <!-- Spacer -->
                            
                            <div class="mt-4">
                                <Link :href="route('frontend.cars.show', car.id)" class="w-full flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 z-10 relative">
                                    View Details
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12" v-if="cars.data.length > 0">
                    <Pagination :links="cars.links" />
                </div>
                
                <div v-if="cars.data.length === 0" class="mt-12 text-center text-gray-500 dark:text-gray-400">
                    No cars found matching your search.
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>