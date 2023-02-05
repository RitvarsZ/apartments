
<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ApartmentMap from '@/Components/ApartmentMap.vue';
import ApartmentPreview from '@/Components/ApartmentPreview.vue';
import { ref } from 'vue';
import { useSeen } from '@/Composables/seen.js';

const props = defineProps({
  apartments: Array,
  seen_apartments: Array,
  favorite_apartments: Array,
});

const selectedApartment = ref(null);
const selectApartment = (id) => {
  selectedApartment.value = props.apartments.find((apartment) => apartment.id === id);

  if (id) {
    useSeen(id);
    seenApartments.value.push(id);
  }
}

const seenApartments = ref(props.seen_apartments);
const favoriteApartments = ref(props.favorite_apartments);

</script>

<template>
  <Head :title="selectedApartment ? selectedApartment.street : 'Karte'" />
  <GuestLayout :fullWidth="true">
    <ApartmentMap
      :apartments="apartments"
      :seenApartments="seenApartments"
      :favoriteApartments="favoriteApartments"
      :selectedId="selectedApartment?.id"
      @feature-click="selectApartment"/>
    <ApartmentPreview :apartment="selectedApartment" @close="selectedApartment = null" />
  </GuestLayout>
</template>
