<script setup>
import { MapboxMap, MapboxCluster } from '@studiometa/vue-mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import { computed, ref } from '@vue/reactivity';
import { defineEmits } from 'vue';
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  apartments: Array,
});

const mapboxToken = usePage().props.mapbox.token;
const mapCenter = ref([24.162616, 56.966349]);
const mapZoom = ref(7);
const mapboxMap = ref(null);
const cluster = computed(() => {
  return {
    type: 'FeatureCollection',
    features: props.apartments.map((apartment) => {
      return {
        type: 'Feature',
        geometry: {
          type: 'Point',
          coordinates: [apartment.longitude, apartment.latitude],
        },
        properties: {
          id: apartment.id,
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
    mapStyle="mapbox://styles/mapbox/streets-v11"
    :center="mapCenter"
    :zoom="mapZoom"
    @mb-created="(map) => mapboxMap = map">
      <MapboxCluster :data="cluster"
        :clusterRadius="20"
        :clustersPaint="{
          'circle-color': '#51bbd6',
          'circle-radius': 18
        }"
        :unclusteredPointPaint="{
          'circle-color': '#ea473a',
          'circle-radius': 8,
        }"
        @mb-cluster-click="(cluster) => { $emit('feature-click', null) }"
        @mb-feature-click="(feature) => { zoomToFeature(feature); $emit('feature-click', feature.properties.id) }">
      </MapboxCluster>
  </MapboxMap>
</template>