<template>
  <div class="p-8 bg-gray-100 min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
      <h1 class="text-3xl header-text-style mb-4">Sistema de Gestión de Historial Clínico de Fisioterapia</h1>
      <p class="text-gray-600 leading-relaxed">
        Bienvenido al sistema de gestión para clínicas de fisioterapia. Esta herramienta está diseñada para ayudarte a administrar los historiales de tus pacientes, gestionar citas y llevar un seguimiento del progreso de manera eficiente y segura. Explora las secciones de Pacientes y Citas para comenzar.
      </p>
    </div>

    <!-- Image Carousel -->
    <div class="relative bg-white rounded-lg shadow-lg overflow-hidden">
      <div class="w-full h-96 flex transition-transform duration-500 ease-in-out" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
        <div v-for="(image, index) in images" :key="index" class="w-full flex-shrink-0 h-full">
          <img :src="image" class="w-full h-full object-cover" :alt="'Fisioterapia ' + (index + 1)">
        </div>
      </div>

      <button @click="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full p-2 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button @click="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full p-2 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>

      <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <div v-for="(image, index) in images" :key="index" @click="currentIndex = index"
             :class="['w-3 h-3 rounded-full cursor-pointer', currentIndex === index ? 'bg-white' : 'bg-gray-400']">
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const images = ref([
  'https://picsum.photos/seed/physio1/1200/800',
  'https://picsum.photos/seed/physio2/1200/800',
  'https://picsum.photos/seed/physio3/1200/800',
  'https://picsum.photos/seed/physio4/1200/800',
]);

const currentIndex = ref(0);

const next = () => {
  currentIndex.value = (currentIndex.value + 1) % images.value.length;
};

const prev = () => {
  currentIndex.value = (currentIndex.value - 1 + images.value.length) % images.value.length;
};
</script>

<style scoped>
/* Scoped styles for dashboard */
</style>