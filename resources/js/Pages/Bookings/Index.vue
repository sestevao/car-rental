<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    bookings: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');

watch([search, status], debounce(function ([newSearch, newStatus]) {
    router.get(route('bookings.index'), { search: newSearch, status: newStatus }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-GB', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'GBP',
    }).format(amount);
};
</script>

<template>
    <Head title="Bookings" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Bookings
                </h2>
                <!-- Breadcrumb or Actions could go here -->
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200">All Bookings</h3>
                    
                    <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                        <div class="relative">
                            <select v-model="status" class="w-full md:w-48 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-sm dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        
                        <div class="relative">
                            <input 
                                v-model="search" 
                                type="text" 
                                placeholder="Search user or car..." 
                                class="w-full md:w-64 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10"
                            />
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-3 font-medium">ID</th>
                                <th class="px-6 py-3 font-medium">User</th>
                                <th class="px-6 py-3 font-medium">Car</th>
                                <th class="px-6 py-3 font-medium">Dates</th>
                                <th class="px-6 py-3 font-medium text-right">Total</th>
                                <th class="px-6 py-3 font-medium text-center">Status</th>
                                <th class="px-6 py-3 font-medium text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr v-for="booking in bookings.data" :key="booking.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs text-gray-500">#{{ booking.id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs shrink-0">
                                            {{ booking.user?.name.charAt(0) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ booking.user?.name || 'Unknown' }}</div>
                                            <div class="text-xs text-gray-500">{{ booking.user?.email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ booking.car?.make }} {{ booking.car?.model }}</div>
                                    <div class="text-xs text-gray-500">{{ booking.car?.year }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 dark:text-white">{{ formatDate(booking.start_date) }}</div>
                                    <div class="text-xs text-gray-500">to {{ formatDate(booking.end_date) }}</div>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-900 dark:text-white">
                                    {{ formatCurrency(booking.total_price) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full capitalize"
                                        :class="{
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': booking.status === 'confirmed' || booking.status === 'completed',
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': booking.status === 'pending',
                                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': booking.status === 'cancelled'
                                        }">
                                        {{ booking.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <Link :href="route('bookings.edit', booking.id)" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-xs">
                                        Edit
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="bookings.data.length === 0">
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-lg font-medium">No bookings found</p>
                                        <p class="text-sm">Try adjusting your search or filters</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <Pagination :links="bookings.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
