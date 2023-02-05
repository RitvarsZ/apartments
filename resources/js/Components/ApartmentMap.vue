<script setup>
import { MapboxMap, MapboxCluster } from '@studiometa/vue-mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import { computed, ref } from '@vue/reactivity';
import { defineEmits } from 'vue';
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  apartments: Array,
  seenApartments: Array,
  favoriteApartments: Array,
  selectedId: { type: Number, default: null },
});

const mapboxToken = usePage().props.mapbox.token;
const mapCenter = ref([24.162616, 56.966349]);
const mapZoom = ref(10);
const mapboxMap = ref(null);
const cluster = computed(() => {
  return {
    type: 'FeatureCollection',
    features: props.apartments.map((apartment) => {
      const getState = () => {
        if (props.selectedId === apartment.id) return 'selected';
        if (props.favoriteApartments.includes(apartment.id)) return 'favorite';
        if (props.seenApartments.includes(apartment.id)) return 'seen';
        return 'unseen';
      }

      return {
        type: 'Feature',
        geometry: {
          type: 'Point',
          coordinates: [apartment.longitude, apartment.latitude],
        },
        properties: {
          id: apartment.id,
          state: getState(),
        },
      };
    }),
  }
});

const zoomToFeature = (feature) => {
  mapboxMap.value.easeTo({
    center: feature.geometry.coordinates,
    zoom: 15,
    duration: 1000,
  });
}

defineEmits(['feature-click']);

</script>

<template>
  <MapboxMap :access-token="mapboxToken"
    style="height: 90vh;"
    mapStyle="mapbox://styles/mapbox/streets-v12"
    :center="mapCenter"
    :zoom="mapZoom"
    @mb-created="(map) => mapboxMap = map">
      <MapboxCluster :data="cluster"
        :clusterRadius="20"
        :clustersPaint="{
          'circle-color': '#51bbd6',
          'circle-radius': 19,
          'circle-stroke-width': 2,
          'circle-stroke-color': '#fff',
        }"
        :unclusteredPointPaint="{
          'circle-color': [
            'match',
            ['get', 'state'],
            'unseen', '#223b53',
            'seen', '#bbb',
            'selected', '#51bbd6',
            'favorite', '#fbb03b',
            /* other */ '#ccc'
          ],
          'circle-radius': [
            'match',
            ['get', 'seenByUser'],
            'false',9,
            'true', 7,
            'selected', 12,
            /* other */ 8
          ],
          'circle-stroke-width': 1,
          'circle-stroke-color': '#000',
        }"
        @mb-cluster-click="(_cluster) => { $emit('feature-click', null) }"
        @mb-feature-click="(feature) => { zoomToFeature(feature); $emit('feature-click', feature.properties.id) }">
      </MapboxCluster>
  </MapboxMap>
</template>