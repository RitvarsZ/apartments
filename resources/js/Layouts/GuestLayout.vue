<script setup>
import NavLink from '@/Components/NavLink.vue';
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
        <header class="flex flex-nowrap w-full sm:max-w-screen-lg">
            <ul class="flex flex-nowrap gap-4 items-center">
                <li>
                    <NavLink :href="route('apartments.index')" :active="route().current('apartments.index')">Saraksts</NavLink>
                </li>
                <li>
                    <NavLink :href="route('apartments.map')" :active="route().current('apartments.map')">Karte</NavLink>
                </li>
            </ul>
            <div class="w-full"/>
            <div v-if="$page.props.auth.user">
                <NavLink :href="route('logout')" method="post" as="button">Iziet</NavLink>
            </div>
            <div v-else class="flex flex-nowrap gap-4">
                <NavLink :href="route('login')" :active="route().current('login')">Ienākt</NavLink>
                <NavLink :href="route('register')" :active="route().current('register')">Reģistrēties</NavLink>
            </div>
        </header>

        <div v-if="fullWidth" class="w-full mt-6">
            <slot />
        </div>
        <div v-else class="w-full sm:max-w-screen-lg mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
