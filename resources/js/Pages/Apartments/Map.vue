
<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ApartmentMap from '@/Components/ApartmentMap.vue';
import ApartmentPreview from '@/Components/ApartmentPreview.vue';
import { ref } from 'vue';

const props = defineProps({
  apartments: Array,
});

const selectedApartment = ref(null);
const selectApartment = (id) => {
  selectedApartment.value = props.apartments.find((apartment) => apartment.id === id);
}


</script>

<template>
  <Head title="Karte" />
  <GuestLayout :fullWidth="true">
    <ApartmentMap :apartments="apartments" @feature-click="selectApartment"/>
    <ApartmentPreview :apartment="selectedApartment" @close="selectedApartment = null" />
  </GuestLayout>
</template>
