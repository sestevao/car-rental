<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    booking: Object,
});

const form = useForm({
    card_holder: '',
    card_number: '',
    expiry_date: '',
    cvv: '',
});

const submit = () => {
    form.post(route('payment.store', props.booking.id));
};
</script>

<template>
    <Head title="Payment" />

    <FrontendLayout>
        <div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8">Secure Checkout</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Booking Summary -->
                    <div class="md:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Booking Summary</h2>
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Car</h3>
                                    <p class="mt-1 text-base text-gray-900 dark:text-white font-semibold">{{ booking.car.make }} {{ booking.car.model }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Dates</h3>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ booking.start_date }} to {{ booking.end_date }}</p>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Price</h3>
                                    <p class="mt-1 text-2xl font-bold text-indigo-600 dark:text-indigo-400">£{{ booking.total_price }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div class="md:col-span-2">
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Payment Details</h2>

                            <!-- Credit Card Preview -->
                            <div class="mb-8 relative max-w-sm mx-auto transform transition-transform hover:scale-105 duration-300">
                                <div class="w-full aspect-[1.586] bg-gradient-to-br from-gray-800 to-gray-900 dark:from-gray-700 dark:to-gray-800 rounded-xl shadow-xl overflow-hidden relative text-white p-6 flex flex-col justify-between border border-gray-700">
                                    
                                    <!-- Background Pattern -->
                                    <div class="absolute inset-0 opacity-10">
                                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                                    <path d="M0 40L40 0H20L0 20M40 40V20L20 40" stroke="white" stroke-width="2"/>
                                                </pattern>
                                            </defs>
                                            <rect width="100%" height="100%" fill="url(#grid)" />
                                        </svg>
                                    </div>

                                    <!-- Top Row: Chip & WiFi -->
                                    <div class="flex justify-between items-start relative z-10">
                                        <div class="w-12 h-9 bg-gradient-to-br from-yellow-200 to-yellow-500 rounded-md border border-yellow-600 flex items-center justify-center overflow-hidden">
                                            <div class="w-full h-[1px] bg-yellow-700/50 absolute top-1/3"></div>
                                            <div class="w-full h-[1px] bg-yellow-700/50 absolute bottom-1/3"></div>
                                            <div class="h-full w-[1px] bg-yellow-700/50 absolute left-1/3"></div>
                                            <div class="h-full w-[1px] bg-yellow-700/50 absolute right-1/3"></div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                                        </svg>
                                    </div>

                                    <!-- Middle: Card Number -->
                                    <div class="relative z-10 mt-4">
                                        <div class="text-2xl font-mono tracking-widest drop-shadow-md">
                                            {{ form.card_number || '0000 0000 0000 0000' }}
                                        </div>
                                    </div>

                                    <!-- Bottom: Details -->
                                    <div class="flex justify-between items-end relative z-10 mt-4">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] uppercase text-gray-400 tracking-wider">Card Holder</span>
                                            <span class="font-medium tracking-wide uppercase truncate max-w-[180px]">{{ form.card_holder || 'YOUR NAME' }}</span>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="text-[10px] uppercase text-gray-400 tracking-wider">Expires</span>
                                            <span class="font-medium tracking-wider">{{ form.expiry_date || 'MM/YY' }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Visa Logo (Simple SVG) -->
                                    <div class="absolute bottom-6 right-6 opacity-20 z-0">
                                         <svg class="w-24 h-8" viewBox="0 0 48 16" fill="currentColor">
                                            <path d="M18.8 16h3.4l2.1-12.6h-3.4l-2.1 12.6zm6.8-12.3l-2.4 12.3h3.4l2.4-12.3h-3.4zm-11.5 12.3l-1.4-7.2c-.3-1.4-1.2-2.3-2.6-2.9 1 .7 1.9 1.9 2.4 4.5l2.2 8.4h3.6l5.5-12.6h-3.6l-3.3 8.3-1.1-5.3h-4.3l.1.5.5.2c.7.2 1.1.6 1.3 1.1zm-14.1 0h11.2v-16h-11.2v16z" fill="none"/> 
                                            <!-- Simple text fallback or abstract shape if full logo is complex -->
                                            <text x="0" y="14" font-family="sans-serif" font-weight="bold" font-style="italic" font-size="14">VISA</text>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <form @submit.prevent="submit" class="space-y-6">
                                <div>
                                    <InputLabel for="card_holder" value="Card Holder Name" />
                                    <TextInput
                                        id="card_holder"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.card_holder"
                                        required
                                        placeholder="John Doe"
                                    />
                                    <InputError class="mt-2" :message="form.errors.card_holder" />
                                </div>

                                <div>
                                    <InputLabel for="card_number" value="Card Number" />
                                    <TextInput
                                        id="card_number"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.card_number"
                                        required
                                        placeholder="0000 0000 0000 0000"
                                        maxlength="19"
                                    />
                                    <InputError class="mt-2" :message="form.errors.card_number" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <InputLabel for="expiry_date" value="Expiry Date" />
                                        <TextInput
                                            id="expiry_date"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.expiry_date"
                                            required
                                            placeholder="MM/YY"
                                            maxlength="5"
                                        />
                                        <InputError class="mt-2" :message="form.errors.expiry_date" />
                                    </div>
                                    <div>
                                        <InputLabel for="cvv" value="CVV" />
                                        <TextInput
                                            id="cvv"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.cvv"
                                            required
                                            placeholder="123"
                                            maxlength="4"
                                        />
                                        <InputError class="mt-2" :message="form.errors.cvv" />
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Pay £{{ booking.total_price }}
                                    </PrimaryButton>
                                    <p class="mt-2 text-xs text-center text-gray-500 dark:text-gray-400">
                                        This is a secure 256-bit SSL encrypted payment.
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>
