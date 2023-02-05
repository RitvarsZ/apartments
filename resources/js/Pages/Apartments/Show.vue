<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
  apartment: Object,
});

</script>

<template>
  <Head :title="`${apartment.street}, ${apartment.district}`" />

  <GuestLayout>
    <div>
      <Link :href="route('apartments.index')">
        <SecondaryButton>Atpakaļ</SecondaryButton>
      </Link>
      <div>
        {{ apartment }}
      </div>
    </div>
  </GuestLayout>
</template>

