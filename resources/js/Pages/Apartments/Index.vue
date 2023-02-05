
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ApartmentCard from '@/Components/ApartmentCard.vue';

defineProps({
  apartments: Array,
});

</script>

<template>
  <Head title="Saraksts" />

  <GuestLayout>
    <div>
      <h1 class="text-3xl font-bold mb-4">Dzīvokļu saraksts</h1>

      <div>
        <Link v-for="apartment in apartments" :key="apartment.id" :href="route('apartments.show', { apartment: apartment.id })">
          <ApartmentCard :apartment="apartment"
            class="mb-4 hover:scale-105 transition-all"/>
        </Link>

      </div>
    </div>
  </GuestLayout>
</template>
