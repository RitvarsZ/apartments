<script setup>
import SecondaryButton from './SecondaryButton.vue';
import PrimaryButton from './PrimaryButton.vue';
import { ref, watch } from 'vue';
import Favorite from './Favorite.vue';

const props = defineProps({
    apartment: { type: Object, default: null },
    isFavorite: { type: Boolean, default: false },
});

const emit = defineEmits(['close', 'set-favorite']);

const isOpen = ref(false);

const onClose = () => {
    isOpen.value = false;
    setTimeout(() => {
        emit('close');
    }, 300);
}

// watch apartment prop
watch(() => props.apartment, (apartment) => {
    if (apartment) {
        isOpen.value = true;
    }
});

</script>

<template>
    <div class="fixed right-0 bottom-0 md:bottom-1/3 w-full scale-95 md:w-1/2 lg:w-1/3 bg-slate-100 drop-shadow-xl p-4 pb-10 pt-5 rounded-2xl transition-all duration-300 ease-in-out overflow-hidden z-50"
        :class="{ 'translate-y-full md:translate-y-0 md:translate-x-full' : !isOpen }">
        <div class="flex flex-nowrap items-center gap-1">
            <SecondaryButton class="w-full justify-center md:w-auto mb-2" @click="onClose">Aizvērt</SecondaryButton>
        </div>
        <template v-if="apartment">
            <div class="flex gap-2">
                <img class="w-44" :src="apartment.image_thumbnail" alt="thumb">
                <p>{{ apartment.title }}</p>
            </div>

            <p class="font-bold">{{ apartment.street }}, {{ apartment.district }}</p>
            <p>Istabas: {{ apartment.rooms }}</p>
            <p>Stāvs: {{ apartment.floor }}</p>
            <p>Sērija: {{ apartment.series }}</p>
            <p class="text-xl font-bold text-blue-600">Cena: {{ apartment.price }} {{ apartment.price_unit }} ({{ apartment.price_per_m2 }} €/m2)</p>

            <p>Pievienots: {{ apartment.published_at }}</p>
            <a :href="apartment.link" target="blank">
                <PrimaryButton class="w-full text-center flex justify-center mt-3">
                    Apskatīt
                </PrimaryButton>
            </a>
            <Favorite :isFavorite="isFavorite" @set-favorite="emit('set-favorite', apartment.id)"/>
        </template>
    </div>
</template>
