<script setup>
import SecondaryButton from './SecondaryButton.vue';
import PrimaryButton from './PrimaryButton.vue';

const props = defineProps({
    apartment: { type: Object, default: null },
});
</script>

<template>
    <div class="fixed right-0 top-0 h-full w-10/12 sm:w-1/3 bg-slate-100 shadow-lg p-4 transition-all duration-300 ease-in-out overflow-hidden"
        :class="{ 'translate-x-full' : apartment === null }">
        <SecondaryButton class="float-right" @click="$emit('close')">Aizvērt</SecondaryButton>
        <template v-if="apartment">
            <p>Pievienots: {{ apartment.published_at }}</p>
            <img :src="apartment.image_thumbnail" alt="thumb">
            <p>{{ apartment.title }}</p>
            <p class="font-bold">{{ apartment.street }}, {{ apartment.district }}</p>
            <p>Istabas: {{ apartment.rooms }}</p>
            <p>Stāvs: {{ apartment.floor }}</p>
            <p>Sērija: {{ apartment.series }}</p>
            <p class="text-xl font-bold text-blue-600">Cena: {{ apartment.price }} {{ apartment.price_unit }} ({{ apartment.price_per_m2 }} €/m2)</p>

            <a :href="apartment.link" target="blank">
                <PrimaryButton class="w-full text-center flex justify-center mt-3">
                    Apskatīt
                </PrimaryButton>
            </a>
        </template>
    </div>
</template>
