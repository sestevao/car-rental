<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    car: Object,
});

const form = useForm({
    make: props.car.make,
    model: props.car.model,
    year: props.car.year,
    price_per_day: props.car.price_per_day,
    status: props.car.status,
    image_url: props.car.image_url,
    seats: props.car.seats,
    transmission: props.car.transmission,
    large_bags: props.car.large_bags,
    small_bags: props.car.small_bags,
    mileage_policy: props.car.mileage_policy,
    location: props.car.location,
    pickup_type: props.car.pickup_type,
    cancellation_policy: props.car.cancellation_policy,
    image: null,
    _method: 'PUT',
});

const imagePreviewError = ref(false);
const imagePreview = ref(null);

const handleImageError = () => {
    imagePreviewError.value = true;
};

const onFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        // Create local preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        form.image = null;
        imagePreview.value = null;
    }
};

watch(() => form.image_url, () => {
    imagePreviewError.value = false;
    if (form.image_url) {
        imagePreview.value = null;
    }
});

const submit = () => {
    form.post(route('cars.update', props.car.id));
};
</script>

<template>
    <Head title="Edit Car" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Edit Vehicle
                </h2>
                <Link
                    :href="route('cars.index')"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition duration-150 ease-in-out"
                >
                    &larr; Back to Fleet
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="mx-auto w-full px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Left Column: Edit Form -->
                    <div class="space-y-6">
                        <form @submit.prevent="submit">
                            
                            <!-- Section 1: Vehicle Identity -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 mb-4">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                        </svg>
                                        Basic Information
                                    </h3>
                                </div>
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Make -->
                                    <div>
                                        <InputLabel for="make" value="Make" />
                                        <TextInput
                                            id="make"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.make"
                                            required
                                            autofocus
                                            autocomplete="make"
                                            placeholder="e.g. Toyota"
                                        />
                                        <InputError class="mt-2" :message="form.errors.make" />
                                    </div>

                                    <!-- Model -->
                                    <div>
                                        <InputLabel for="model" value="Model" />
                                        <TextInput
                                            id="model"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.model"
                                            required
                                            autocomplete="model"
                                            placeholder="e.g. Camry"
                                        />
                                        <InputError class="mt-2" :message="form.errors.model" />
                                    </div>

                                    <!-- Year -->
                                    <div>
                                        <InputLabel for="year" value="Year" />
                                        <TextInput
                                            id="year"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="form.year"
                                            required
                                            placeholder="e.g. 2024"
                                        />
                                        <InputError class="mt-2" :message="form.errors.year" />
                                    </div>

                                    <!-- Price -->
                                    <div>
                                        <InputLabel for="price_per_day" value="Price Per Day" />
                                        <div class="relative mt-1 rounded-md shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <TextInput
                                                id="price_per_day"
                                                type="number"
                                                step="0.01"
                                                class="block w-full pl-7"
                                                v-model="form.price_per_day"
                                                required
                                            />
                                        </div>
                                        <InputError class="mt-2" :message="form.errors.price_per_day" />
                                    </div>

                                    <!-- Status -->
                                    <div class="md:col-span-2">
                                        <InputLabel for="status" value="Status" />
                                        <select
                                            id="status"
                                            v-model="form.status"
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 rounded-md shadow-sm"
                                            required
                                        >
                                            <option value="available">Available</option>
                                            <option value="rented">Rented</option>
                                            <option value="maintenance">Maintenance</option>
                                        </select>
                                        <InputError class="mt-2" :message="form.errors.status" />
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Specs & Logistics -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 mb-4">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Specifications & Logistics
                                    </h3>
                                </div>
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Seats -->
                                    <div>
                                        <InputLabel for="seats" value="Seats" />
                                        <TextInput
                                            id="seats"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="form.seats"
                                        />
                                        <InputError class="mt-2" :message="form.errors.seats" />
                                    </div>

                                    <!-- Transmission -->
                                    <div>
                                        <InputLabel for="transmission" value="Transmission" />
                                        <select
                                            id="transmission"
                                            v-model="form.transmission"
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 rounded-md shadow-sm"
                                        >
                                            <option value="">Select Transmission</option>
                                            <option value="Manual">Manual</option>
                                            <option value="Automatic">Automatic</option>
                                        </select>
                                        <InputError class="mt-2" :message="form.errors.transmission" />
                                    </div>

                                    <!-- Bags -->
                                    <div>
                                        <InputLabel for="large_bags" value="Large Bags" />
                                        <TextInput
                                            id="large_bags"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="form.large_bags"
                                        />
                                        <InputError class="mt-2" :message="form.errors.large_bags" />
                                    </div>
                                    <div>
                                        <InputLabel for="small_bags" value="Small Bags" />
                                        <TextInput
                                            id="small_bags"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="form.small_bags"
                                        />
                                        <InputError class="mt-2" :message="form.errors.small_bags" />
                                    </div>

                                    <!-- Mileage -->
                                    <div class="md:col-span-2">
                                        <InputLabel for="mileage_policy" value="Mileage Policy" />
                                        <TextInput
                                            id="mileage_policy"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.mileage_policy"
                                            placeholder="e.g. 300 miles per rental"
                                        />
                                        <InputError class="mt-2" :message="form.errors.mileage_policy" />
                                    </div>

                                    <!-- Location -->
                                    <div class="md:col-span-2">
                                        <InputLabel for="location" value="Location" />
                                        <TextInput
                                            id="location"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.location"
                                            placeholder="e.g. London Heathrow Airport"
                                        />
                                        <InputError class="mt-2" :message="form.errors.location" />
                                    </div>

                                    <!-- Pickup & Cancel -->
                                    <div>
                                        <InputLabel for="pickup_type" value="Pickup Type" />
                                        <TextInput
                                            id="pickup_type"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.pickup_type"
                                            placeholder="e.g. Shuttle Bus"
                                        />
                                        <InputError class="mt-2" :message="form.errors.pickup_type" />
                                    </div>
                                    <div>
                                        <InputLabel for="cancellation_policy" value="Cancellation Policy" />
                                        <TextInput
                                            id="cancellation_policy"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.cancellation_policy"
                                            placeholder="e.g. Free cancellation"
                                        />
                                        <InputError class="mt-2" :message="form.errors.cancellation_policy" />
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Media -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 mb-4">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                        Vehicle Image
                                    </h3>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <!-- File Input -->
                                        <div>
                                            <InputLabel for="image" value="Upload New Image" />
                                            <div class="mt-2">
                                                <input
                                                    type="file"
                                                    id="image"
                                                    @change="onFileChange"
                                                    accept="image/*"
                                                    class="block w-full text-sm text-gray-500
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-full file:border-0
                                                        file:text-sm file:font-semibold
                                                        file:bg-indigo-50 file:text-indigo-700
                                                        hover:file:bg-indigo-100
                                                        transition duration-150 ease-in-out
                                                    "
                                                />
                                            </div>
                                            <InputError class="mt-2" :message="form.errors.image" />
                                        </div>

                                        <div class="relative">
                                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                            </div>
                                            <div class="relative flex justify-center">
                                                <span class="bg-white dark:bg-gray-800 px-2 text-sm text-gray-500">or use URL</span>
                                            </div>
                                        </div>

                                        <!-- URL Input -->
                                        <div>
                                            <InputLabel for="image_url" value="Image URL" />
                                            <TextInput
                                                id="image_url"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="form.image_url"
                                                placeholder="https://example.com/car-image.jpg"
                                            />
                                            <InputError class="mt-2" :message="form.errors.image_url" />
                                        </div>

                                        <!-- Preview -->
                                        <div v-if="(form.image_url || imagePreview) && !imagePreviewError" class="mt-4">
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview</p>
                                            <div class="relative aspect-video w-full rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                                                <img 
                                                    :src="imagePreview || form.image_url" 
                                                    alt="Car Preview" 
                                                    class="absolute inset-0 w-full h-full object-cover"
                                                    @error="handleImageError" 
                                                />
                                            </div>
                                        </div>
                                        <div v-else-if="form.image_url && imagePreviewError" class="mt-4 p-4 rounded-md bg-red-50 dark:bg-red-900/20 text-sm text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800">
                                            Unable to load image. Please check the URL.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-4">
                                <Link
                                    :href="route('cars.index')"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    Cancel
                                </Link>
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Save Changes
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>

                    <!-- Right Column: Booking History -->
                    <div class="space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 h-fit sticky top-6">
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-indigo-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Booking History
                                </h3>
                            </div>
                            
                            <div class="p-0">
                                <div v-if="car.bookings && car.bookings.length > 0" class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            <tr v-for="booking in car.bookings" :key="booking.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ booking.user ? booking.user.name : 'Unknown' }}</div>
                                                    <div class="text-xs text-gray-500">{{ booking.user ? booking.user.email : '' }}</div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ booking.start_date }}</div>
                                                    <div class="text-xs text-gray-500">to {{ booking.end_date }}</div>
                                                    <div class="text-xs font-medium text-indigo-600 mt-1">${{ booking.total_price }}</div>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-medium rounded-full"
                                                        :class="{
                                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': booking.status === 'confirmed' || booking.status === 'completed',
                                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200': booking.status === 'pending',
                                                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': booking.status === 'cancelled'
                                                        }">
                                                        {{ booking.status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else class="p-6 text-center text-gray-500 dark:text-gray-400">
                                    <p class="mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto text-gray-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0h18M5.25 12h13.5h-13.5zm1.5 6h13.5h-13.5z" />
                                        </svg>
                                    </p>
                                    No bookings found for this car.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
