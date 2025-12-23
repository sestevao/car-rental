<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array,
});
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links">
                <div v-if="link.url === null" :key="key" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 dark:text-gray-600 border-none rounded" v-html="link.label" />
                <Link v-else :key="`link-${key}`" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border-none rounded hover:bg-white dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:text-indigo-500 dark:focus:text-indigo-400" :class="{ 'bg-blue-700 dark:bg-indigo-600 text-white dark:text-white': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>
