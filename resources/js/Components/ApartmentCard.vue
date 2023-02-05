<script setup>
defineProps({
    apartment: { type: Object },
});
</script>

<template>
    <div class="grid grid-cols-12 sm:gap-4 border rounded-md shadow-sm p-1 items-center">
        <div class="col-span-2 align-top">
            <img :src="apartment.image_thumbnail" alt="apartment image" class="w-full">
        </div>
        <div class="col-span-10 p-1 flex flex-wrap h-full">
            <div>{{ apartment.title }}</div>
            <div class="flex flex-nowrap gap-5 mt-2">
                <div><b>Istabas:</b> {{ apartment.rooms }}</div>
                <div>{{ apartment.m2 }} m2</div>
                <div><b>Cena:</b> {{ apartment.price }} {{ apartment.price_unit }} ({{ apartment.price_per_m2 }} €/m2)</div>
            </div>
        </div>
    </div>
</template>
