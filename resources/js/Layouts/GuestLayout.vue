<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    fullWidth: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-top items-center pt-6 sm:pt-6 bg-gray-100">
        <header>
            <ul class="flex flex-nowrap gap-4 items-center">
                <li :class="{ 'font-bold': route().current() === 'apartments.index' }">
                    <Link :href="route('apartments.index')" class="text-gray-700 underline">Saraksts</Link>
                </li>
                <li :class="{ 'font-bold': route().current() === 'apartments.map' }">
                    <Link :href="route('apartments.map')" class="text-gray-700 underline">Karte</Link>
                </li>
            </ul>
        </header>

        <div v-if="fullWidth" class="w-full mt-6">
            <slot />
        </div>
        <div v-else class="w-full sm:max-w-screen-lg mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
