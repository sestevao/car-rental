<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { computed } from 'vue';

const props = defineProps({
    car: Object,
});

const user = usePage().props.auth.user;

const form = useForm({
    car_id: props.car.id,
    start_date: '',
    end_date: '',
});

const submit = () => {
    form.post(route('bookings.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const totalPrice = computed(() => {
    if (form.start_date && form.end_date) {
        const start = new Date(form.start_date);
        const end = new Date(form.end_date);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        
        // Ensure at least 1 day if dates are valid
        if (diffDays >= 0 && !isNaN(diffDays)) {
             // If start == end, let's say it's 1 day rental or 0 depending on logic, 
             // but backend uses max(1, diff).
             // Let's match backend logic roughly.
             const days = Math.max(1, diffDays);
             return (days * props.car.price_per_day).toFixed(2);
        }
    }
    return 0;
});
</script>

<template>
    <Head :title="`${car.make} ${car.model}`" />

    <FrontendLayout>
        <div class="bg-white dark:bg-gray-900 min-h-screen py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
                    <!-- Image gallery -->
                    <div class="flex flex-col">
                        <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden sm:aspect-w-2 sm:aspect-h-3">
                            <img :src="car.image_url || 'https://via.placeholder.com/600x400'" :alt="car.make + ' ' + car.model" class="w-full h-full object-center object-cover" />
                        </div>
                    </div>

                    <!-- Car info -->
                    <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ car.make }} {{ car.model }}</h1>

                        <div class="mt-3">
                            <h2 class="sr-only">Product information</h2>
                            <p class="text-3xl text-gray-900 dark:text-gray-100">£{{ car.price_per_day }} <span class="text-sm text-gray-500">/ day</span></p>
                        </div>

                        <div class="mt-6">
                            <h3 class="sr-only">Description</h3>
                            <div class="text-base text-gray-700 dark:text-gray-300 space-y-6">
                                <p>Year: {{ car.year }}</p>
                                <p>Status: <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" :class="car.status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">{{ car.status }}</span></p>
                                <p v-if="car.transmission">Transmission: {{ car.transmission }}</p>
                                <p v-if="car.seats">Seats: {{ car.seats }}</p>
                                <!-- Add more details here if available -->
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Book this car</h2>

                            <div v-if="user">
                                <form @submit.prevent="submit" class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                        <div class="mt-1">
                                            <input type="date" id="start_date" v-model="form.start_date" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white" required :min="new Date().toISOString().split('T')[0]" />
                                            <div v-if="form.errors.start_date" class="text-red-500 text-xs mt-1">{{ form.errors.start_date }}</div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                        <div class="mt-1">
                                            <input type="date" id="end_date" v-model="form.end_date" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white" required :min="form.start_date || new Date().toISOString().split('T')[0]" />
                                            <div v-if="form.errors.end_date" class="text-red-500 text-xs mt-1">{{ form.errors.end_date }}</div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <div v-if="totalPrice > 0" class="mb-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-md">
                                            <p class="text-lg font-medium text-gray-900 dark:text-white">Estimated Total: £{{ totalPrice }}</p>
                                        </div>
                                        
                                        <button type="submit" :disabled="form.processing" class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                            {{ form.processing ? 'Booking...' : 'Book Now' }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div v-else class="mt-4 bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Login Required</h3>
                                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                            <p>You must be logged in to book a car.</p>
                                        </div>
                                        <div class="mt-4">
                                            <div class="-mx-2 -my-1.5 flex">
                                                <Link :href="route('login')" class="bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1.5 rounded-md text-sm font-medium text-yellow-800 dark:text-yellow-200 hover:bg-yellow-100 dark:hover:bg-yellow-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-600">
                                                    Login
                                                </Link>
                                                <Link :href="route('register')" class="ml-3 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1.5 rounded-md text-sm font-medium text-yellow-800 dark:text-yellow-200 hover:bg-yellow-100 dark:hover:bg-yellow-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-600">
                                                    Register
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>