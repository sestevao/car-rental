<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    stats: Object,
    cars: Array,
    earningSummary: Array,
});

// Format currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-GB', { style: 'currency', currency: 'GBP' }).format(value);
};

// Pie Chart Logic
const pieData = computed(() => {
    const total = props.stats.bookings_today.hired + props.stats.bookings_today.canceled + props.stats.bookings_today.pending;
    if (total === 0) return [];
    
    let currentAngle = 0;
    const data = [
        { label: 'Hired', value: props.stats.bookings_today.hired, color: '#10B981' }, // Green
        { label: 'Canceled', value: props.stats.bookings_today.canceled, color: '#EF4444' }, // Red
        { label: 'Pending', value: props.stats.bookings_today.pending, color: '#F59E0B' }, // Yellow
    ];

    return data.map(item => {
        const angle = (item.value / total) * 360;
        const startAngle = currentAngle;
        const endAngle = currentAngle + angle;
        currentAngle += angle;
        
        // Calculate SVG path for slice
        const x1 = 50 + 50 * Math.cos(Math.PI * startAngle / 180);
        const y1 = 50 + 50 * Math.sin(Math.PI * startAngle / 180);
        const x2 = 50 + 50 * Math.cos(Math.PI * endAngle / 180);
        const y2 = 50 + 50 * Math.sin(Math.PI * endAngle / 180);
        
        const largeArcFlag = angle > 180 ? 1 : 0;
        
        const path = `M 50 50 L ${x1} ${y1} A 50 50 0 ${largeArcFlag} 1 ${x2} ${y2} Z`;
        
        return { ...item, path };
    }).filter(item => item.value > 0);
});

// Line Chart Logic (Earning Summary)
const lineChartPath = computed(() => {
    if (!props.earningSummary || props.earningSummary.length === 0) return '';
    
    const maxVal = Math.max(...props.earningSummary.map(d => Math.max(d.current, d.previous))) || 100;
    const points = props.earningSummary.map((d, i) => {
        const x = (i / (props.earningSummary.length - 1)) * 300; // Width 300
        const y = 100 - (d.current / maxVal) * 100; // Height 100
        return `${x},${y}`;
    }).join(' ');
    
    return points;
});

const prevLineChartPath = computed(() => {
    if (!props.earningSummary || props.earningSummary.length === 0) return '';
    
    const maxVal = Math.max(...props.earningSummary.map(d => Math.max(d.current, d.previous))) || 100;
    const points = props.earningSummary.map((d, i) => {
        const x = (i / (props.earningSummary.length - 1)) * 300;
        const y = 100 - (d.previous / maxVal) * 100;
        return `${x},${y}`;
    }).join(' ');
    
    return points;
});

// Availability Check (Mock)
const checkForm = useForm({
    car_number: '',
    start_date: '',
    end_date: '',
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- Top Toolbar -->
        <div class="bg-white dark:bg-gray-800 mb-4 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-96">
                <input type="text" placeholder="Search for anything..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" />
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>
        </div>

        <!-- No header slot used as per design preference -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">    
            <!-- Column 1: Statistics (Income, Expenses, Hire/Cancel) -->
            <div class="xl:col-span-1 space-y-6">
                <!-- Income Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200">Income</h3>
                        <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ formatCurrency(stats.income.today) }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Today</div>
                    </div>
                    <div class="flex flex-col items-start justify-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center justify-center gap-2">
                            Compared to 
                            <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ formatCurrency(stats.income.yesterday) }}</span> 
                            yesterday
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <div class="text-xs text-gray-500 dark:text-gray-400">Last week Income</div>
                            <div class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ formatCurrency(stats.income.last_week) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Expenses Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200">Expenses</h3>
                        <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ formatCurrency(stats.expenses.today) }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Today</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div>
                            <div class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ formatCurrency(stats.expenses.yesterday) }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Yesterday</div>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ formatCurrency(stats.expenses.last_week) }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Last Week</div>
                        </div>
                    </div>
                </div>

                <!-- Hire vs Cancel Graph -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-6">Today's Activity</h3>
                    <div class="flex items-center justify-center mb-6">
                        <!-- SVG Pie Chart -->
                        <div class="relative w-48 h-48">
                            <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                                <path v-for="(slice, index) in pieData" :key="index" :d="slice.path" :fill="slice.color" />
                                <circle v-if="pieData.length === 0" cx="50" cy="50" r="50" fill="#E5E7EB" />
                            </svg>
                            <!-- Inner Circle for Donut Effect (Optional) -->
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-24 h-24 bg-white dark:bg-gray-800 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Hired ({{ stats.bookings_today.hired }})</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Canceled ({{ stats.bookings_today.canceled }})</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Pending ({{ stats.bookings_today.pending }})</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Column 2 & 3: Operations (Toolbar, Availability, Live Status, Earning Graph) -->
            <div class="xl:col-span-2 space-y-6">

                <!-- Car Availability Check -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Check Car Availability</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-1">
                            <input v-model="checkForm.car_number" type="text" placeholder="Car Number" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        </div>
                        <div class="md:col-span-1">
                            <input v-model="checkForm.start_date" type="date" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        </div>
                        <div class="md:col-span-1">
                            <input v-model="checkForm.end_date" type="date" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        </div>
                        <div class="md:col-span-1">
                            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                Check
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Live Car Status Table -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200">Live Car Status</h3>
                        <div class="flex items-center gap-4">
                            <Link :href="route('bookings.index')" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                View All Bookings
                            </Link>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-500">Filter:</span>
                                <select class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md focus:ring-indigo-500 focus:border-indigo-500 py-1">
                                    <option>All Status</option>
                                    <option>Hired</option>
                                    <option>Available</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase text-gray-700 dark:text-gray-300">
                                <tr>
                                    <th class="px-6 py-3">No.</th>
                                    <th class="px-6 py-3">Car No.</th>
                                    <th class="px-6 py-3">Driver</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Earning</th>
                                    <th class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <tr v-for="(car, index) in cars" :key="car.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">{{ index + 1 }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-3">
                                            <!-- Placeholder Image -->
                                            <div class="w-8 h-8 rounded bg-gray-200 dark:bg-gray-700 flex-shrink-0 overflow-hidden">
                                                <img v-if="car.image_url" :src="car.image_url" class="w-full h-full object-cover" />
                                            </div>
                                            <div>
                                                <div>{{ car.car_no }}</div>
                                                <div class="text-xs text-gray-500">{{ car.make_model }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">{{ car.driver }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full"
                                            :class="{
                                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': car.status === 'Hired' || car.status === 'Available',
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': car.status === 'Maintenance',
                                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': car.status === 'Rented' // Using 'Hired' in controller but checking here
                                            }">
                                            {{ car.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-900 dark:text-white">{{ formatCurrency(car.earning) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400 font-medium text-xs">Details</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Earning Summary Graph -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-6">Earning Summary</h3>
                    <div class="h-64 relative">
                         <!-- Simple SVG Line Chart -->
                         <svg viewBox="0 0 300 100" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                            <!-- Grid Lines -->
                            <line x1="0" y1="0" x2="300" y2="0" stroke="#E5E7EB" stroke-width="0.5" stroke-dasharray="2" />
                            <line x1="0" y1="50" x2="300" y2="50" stroke="#E5E7EB" stroke-width="0.5" stroke-dasharray="2" />
                            <line x1="0" y1="100" x2="300" y2="100" stroke="#E5E7EB" stroke-width="0.5" stroke-dasharray="2" />
                            
                            <!-- Previous Year Line (Gray) -->
                            <polyline :points="prevLineChartPath" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-dasharray="4" />
                            
                            <!-- Current Year Line (Indigo) -->
                            <polyline :points="lineChartPath" fill="none" stroke="#4F46E5" stroke-width="2" />
                            
                            <!-- Points -->
                            <circle v-for="(point, i) in earningSummary" :key="'curr-'+i" 
                                :cx="(i / (earningSummary.length - 1)) * 300" 
                                :cy="100 - (point.current / (Math.max(...earningSummary.map(d => Math.max(d.current, d.previous))) || 100)) * 100" 
                                r="3" fill="#4F46E5" />
                        </svg>
                    </div>
                    <div class="flex justify-between mt-4 text-xs text-gray-500">
                        <span v-for="item in earningSummary" :key="item.month">{{ item.month }}</span>
                    </div>
                    <div class="flex justify-center gap-6 mt-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-1 bg-indigo-600"></span>
                            <span class="text-gray-600 dark:text-gray-400">This Year</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-1 bg-gray-400 border-dashed border-t-2"></span>
                            <span class="text-gray-600 dark:text-gray-400">Last Year</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
