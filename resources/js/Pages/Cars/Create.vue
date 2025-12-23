<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    make: '',
    model: '',
    year: new Date().getFullYear(),
    price_per_day: '',
    status: 'available',
    image_url: '',
    image: null,
    seats: '',
    transmission: '',
    large_bags: '',
    small_bags: '',
    mileage_policy: '',
    location: '',
    pickup_type: '',
    cancellation_policy: '',
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
        imagePreview.value = null; // Clear file preview if URL is manually entered
    }
});

const submit = () => {
    form.post(route('cars.store'));
};
</script>

<template>
    <Head title="Add Car" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Add New Car
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        <form @submit.prevent="submit" class="max-w-xl">
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
                                />
                                <InputError class="mt-2" :message="form.errors.make" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="model" value="Model" />
                                <TextInput
                                    id="model"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.model"
                                    required
                                    autocomplete="model"
                                />
                                <InputError class="mt-2" :message="form.errors.model" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="year" value="Year" />
                                <TextInput
                                    id="year"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="form.year"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.year" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="price_per_day" value="Price Per Day" />
                                <TextInput
                                    id="price_per_day"
                                    type="number"
                                    step="0.01"
                                    class="mt-1 block w-full"
                                    v-model="form.price_per_day"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.price_per_day" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="status" value="Status" />
                                <select
                                    id="status"
                                    v-model="form.status"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required
                                >
                                    <option value="available">Available</option>
                                    <option value="rented">Rented</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.status" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
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
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
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
                            </div>

                            <div class="mt-4">
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

                            <div class="mt-4">
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

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
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

                            <div class="mt-4">
                                <InputLabel for="image" value="Car Image" />
                                <div class="mt-2 flex items-center gap-x-3">
                                    <input
                                        type="file"
                                        id="image"
                                        @change="onFileChange"
                                        accept="image/*"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    />
                                </div>
                                <InputError class="mt-2" :message="form.errors.image" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="image_url" value="Or Image URL (Optional)" />
                                <TextInput
                                    id="image_url"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.image_url"
                                    placeholder="https://example.com/car-image.jpg"
                                />
                                <InputError class="mt-2" :message="form.errors.image_url" />

                                <div v-if="(form.image_url || imagePreview) && !imagePreviewError" class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Preview:</p>
                                    <img 
                                        :src="imagePreview || form.image_url" 
                                        alt="Car Preview" 
                                        class="w-full max-w-md h-48 object-cover rounded-lg shadow-md" 
                                        @error="handleImageError" 
                                    />
                                </div>
                                <div v-else-if="form.image_url && imagePreviewError" class="mt-2 text-sm text-red-500">
                                    Unable to load image. Please check the URL.
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-4">
                                <PrimaryButton :disabled="form.processing">
                                    Save Car
                                </PrimaryButton>

                                <Link
                                    :href="route('cars.index')"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                >
                                    Cancel
                                </Link>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
