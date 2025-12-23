<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    booking: Object,
    cars: Array,
});

const form = useForm({
    car_id: props.booking.car_id,
    start_date: props.booking.start_date.split(' ')[0], // Format YYYY-MM-DD
    end_date: props.booking.end_date.split(' ')[0],
    status: props.booking.status,
});

const submit = () => {
    form.put(route('bookings.update', props.booking.id));
};
</script>

<template>
    <Head title="Edit Booking" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Edit Booking #{{ booking.id }}
                </h2>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden max-w-3xl">
                <div class="p-6">
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div>
                            <InputLabel value="User" />
                            <div class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-500 text-sm">
                                {{ booking.user.name }} ({{ booking.user.email }})
                            </div>
                        </div>

                        <div>
                            <InputLabel for="car_id" value="Car" />
                            <select
                                id="car_id"
                                v-model="form.car_id"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 text-sm"
                            >
                                <option v-for="car in cars" :key="car.id" :value="car.id">
                                    {{ car.make }} {{ car.model }} ({{ car.year }}) - ${{ car.daily_rate }}/day
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.car_id" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="start_date" value="Start Date" />
                                <TextInput
                                    id="start_date"
                                    type="date"
                                    class="mt-1 block w-full rounded-lg"
                                    v-model="form.start_date"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.start_date" />
                            </div>

                            <div>
                                <InputLabel for="end_date" value="End Date" />
                                <TextInput
                                    id="end_date"
                                    type="date"
                                    class="mt-1 block w-full rounded-lg"
                                    v-model="form.end_date"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.end_date" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="status" value="Status" />
                            <select
                                id="status"
                                v-model="form.status"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 text-sm"
                            >
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.status" />
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <PrimaryButton :disabled="form.processing">Save Changes</PrimaryButton>
                            
                            <Link
                                :href="route('bookings.index')"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
