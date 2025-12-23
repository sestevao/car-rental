<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    notifications: Array,
});

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffTime = Math.abs(now - date);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays <= 1) {
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    } else if (diffDays <= 7) {
        return date.toLocaleDateString('en-US', { weekday: 'short' });
    } else {
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }
};

const getIconColor = (type) => {
    switch (type) {
        case 'booking_confirmed': return 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400';
        case 'payment_received': return 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400';
        case 'maintenance_alert': return 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400';
        case 'system_update': return 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400';
        default: return 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400';
    }
};

const getIcon = (type) => {
    switch (type) {
        case 'booking_confirmed': 
            return `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />`;
        case 'payment_received': 
            return `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />`;
        case 'maintenance_alert': 
            return `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />`;
        case 'system_update': 
            return `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />`;
        default: 
            return `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />`;
    }
};

</script>

<template>
    <Head title="Notifications" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Notifications
                </h2>
                <button class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                    Mark all as read
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden max-w-3xl">
                <div v-if="notifications.length > 0" class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div v-for="notification in notifications" :key="notification.id" 
                        class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors flex gap-4"
                        :class="{ 'bg-indigo-50/50 dark:bg-indigo-900/10': !notification.read_at }">
                        
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" :class="getIconColor(notification.type)">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" v-html="getIcon(notification.type)"></svg>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate" :class="{ 'font-bold': !notification.read_at }">
                                    {{ notification.title }}
                                </h3>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ formatDate(notification.created_at) }}</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                {{ notification.message }}
                            </p>
                        </div>
                        
                        <div v-if="!notification.read_at" class="flex flex-col justify-center">
                             <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                        </div>
                    </div>
                </div>
                
                <div v-else class="p-12 text-center text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /> </svg>
                        <p class="text-lg font-medium">No notifications</p>
                        <p class="text-sm">You're all caught up!</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
