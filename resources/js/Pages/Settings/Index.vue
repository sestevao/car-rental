<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeTab = ref('general');

const tabs = [
    { id: 'general', name: 'General', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />' },
    { id: 'notifications', name: 'Notifications', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />' },
    { id: 'security', name: 'Security', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />' },
    { id: 'billing', name: 'Billing', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />' },
];

const generalSettings = ref({
    siteName: 'Car Rental',
    siteEmail: 'support@carrental.com',
    currency: 'GBP',
    timezone: 'UTC',
    language: 'English',
});

const notificationSettings = ref({
    emailAlerts: true,
    smsAlerts: false,
    marketingEmails: true,
});

</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Settings
            </h2>

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Sidebar Navigation -->
                <div class="w-full md:w-64 shrink-0">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <nav class="flex flex-col">
                            <button 
                                v-for="tab in tabs" 
                                :key="tab.id"
                                @click="activeTab = tab.id"
                                class="flex items-center px-6 py-4 text-sm font-medium transition-colors border-l-4"
                                :class="activeTab === tab.id 
                                    ? 'border-indigo-500 text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 dark:text-indigo-400' 
                                    : 'border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-200'"
                            >
                                <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" v-html="tab.icon"></svg>
                                {{ tab.name }}
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="flex-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        
                        <!-- General Settings -->
                        <div v-if="activeTab === 'general'" class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-4">General Settings</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site Name</label>
                                    <input v-model="generalSettings.siteName" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-sm dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Support Email</label>
                                    <input v-model="generalSettings.siteEmail" type="email" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-sm dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Currency</label>
                                    <select v-model="generalSettings.currency" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-sm dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="GBP">GBP (£)</option>
                                        <option value="EUR">EUR (€)</option>
                                        <option value="USD">USD ($)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Timezone</label>
                                    <select v-model="generalSettings.timezone" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 text-sm dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="UTC">UTC</option>
                                        <option value="EST">EST</option>
                                        <option value="PST">PST</option>
                                    </select>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </div>

                        <!-- Notifications Settings -->
                        <div v-if="activeTab === 'notifications'" class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-4">Notification Preferences</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Email Alerts</h4>
                                        <p class="text-xs text-gray-500">Receive notifications about bookings via email.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" v-model="notificationSettings.emailAlerts" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">SMS Alerts</h4>
                                        <p class="text-xs text-gray-500">Receive notifications about bookings via SMS.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" v-model="notificationSettings.smsAlerts" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Marketing Emails</h4>
                                        <p class="text-xs text-gray-500">Receive emails about new features and promotions.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" v-model="notificationSettings.marketingEmails" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                    Save Preferences
                                </button>
                            </div>
                        </div>

                        <!-- Security Settings Placeholder -->
                        <div v-if="activeTab === 'security'" class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-4">Security Settings</h3>
                            <p class="text-gray-500 text-sm">Change password and security options here.</p>
                            <!-- Add password change form here -->
                        </div>

                        <!-- Billing Settings Placeholder -->
                        <div v-if="activeTab === 'billing'" class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-4">Billing & Plans</h3>
                            <p class="text-gray-500 text-sm">Manage your billing details and subscription plans.</p>
                            <!-- Add billing details here -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
