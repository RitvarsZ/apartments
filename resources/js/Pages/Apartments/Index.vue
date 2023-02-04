
<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  apartments: Array,
});
</script>

<template>
  <Head title="Welcome" />

  <div>
    <h1 class="text-3xl font-bold mb-4">Apartments</h1>

    <ul>
      <li v-for="apartment in apartments" :key="apartment.id">
        <Link :href="route('apartments.show', apartment.id)">
          {{ apartment.name }}
        </Link>
      </li>
    </ul>
  </div>
</template>
