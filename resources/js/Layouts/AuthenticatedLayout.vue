<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const showingReportsDropdown = ref(false);
</script>

<template>
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900 overflow-hidden">
        <!-- Sidebar (Desktop) -->
        <aside class="hidden md:flex flex-col w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-center h-16 border-b border-gray-100 dark:border-gray-700 shrink-0">
                <Link :href="route('dashboard')">
                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </Link>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </ResponsiveNavLink>
                
                <ResponsiveNavLink :href="route('drivers.index')" :active="route().current('drivers.*')">
                    Drivers
                </ResponsiveNavLink>

                <ResponsiveNavLink :href="route('bookings.index')" :active="route().current('bookings.*')">
                    Bookings
                </ResponsiveNavLink>
                
                <ResponsiveNavLink :href="route('cars.index')" :active="route().current('cars.*')">
                    Cars
                </ResponsiveNavLink>

                <ResponsiveNavLink :href="route('notifications.index')" :active="route().current('notifications.*')">
                    Notifications
                </ResponsiveNavLink>

                <ResponsiveNavLink :href="route('settings.index')" :active="route().current('settings.*')">
                    Settings
                </ResponsiveNavLink>

                <!-- Reports Dropdown -->
                <div class="flex w-full items-center ps-3  pt-10 pb-2 text-start text-base font-medium text-gray-600 dark:text-gray-400 focus:outline-none transition duration-150 ease-in-out">
                    <span class="flex-1">Report</span>
                </div>
                <ResponsiveNavLink :href="route('reports.payment-details')" :active="route().current('reports.payment-details')" class="text-sm">Payment Details</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('reports.transactions')" :active="route().current('reports.transactions')" class="text-sm">Transactions</ResponsiveNavLink>
                <ResponsiveNavLink :href="route('reports.cars')" :active="route().current('reports.cars')" class="text-sm">Car Report</ResponsiveNavLink>
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm z-10 shrink-0">
                 <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Mobile Hamburger -->
                    <div class="-me-2 flex items-center md:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400"
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

                    <!-- Page Title / Slot -->
                    <div class="flex-1 flex justify-center md:justify-start px-4">
                        <div v-if="$slots.header">
                            <slot name="header" />
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="flex items-center">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
                                    >
                                        {{ $page.props.auth.user.name }}

                                        <svg
                                            class="-me-0.5 ms-2 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Profile
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                 </div>

                 <!-- Mobile Navigation Menu -->
                 <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800"
                >
                    <div class="space-y-1 pb-3 pt-2 px-2">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('cars.index')" :active="route().current('cars.*')">
                            Cars
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('bookings.index')" :active="route().current('bookings.*')">
                            Bookings
                        </ResponsiveNavLink>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reports</div>
                        <ResponsiveNavLink :href="route('reports.payment-details')" :active="route().current('reports.payment-details')">
                            Payment Details
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('reports.transactions')" :active="route().current('reports.transactions')">
                            Transactions
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('reports.cars')" :active="route().current('reports.cars')">
                            Car Report
                        </ResponsiveNavLink>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
