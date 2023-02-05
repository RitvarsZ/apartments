<script setup>
const props = defineProps({
  isFavorite: Boolean,
});

const emit = defineEmits(['set-favorite']);
</script>

<template>
  <div class="text-xl cursor-pointer transition-all" @click="emit('set-favorite')">
    <span v-if="props.isFavorite">❤</span>
    <span v-else>🤍</span>
  </div>
</template>