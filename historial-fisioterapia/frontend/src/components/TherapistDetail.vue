<template>
  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-40">
    <div class="relative mx-auto p-8 border w-full max-w-lg shadow-lg rounded-md bg-white">
      <h3 class="text-2xl font-bold mb-6">Detalles del Terapeuta</h3>
      <div v-if="therapist" class="space-y-4">
        <div>
          <label class="text-gray-500 text-sm font-bold">Nombre:</label>
          <p class="text-gray-800 text-lg">{{ therapist.name }}</p>
        </div>
        <div>
          <label class="text-gray-500 text-sm font-bold">Email:</label>
          <p class="text-gray-800 text-lg">{{ therapist.email }}</p>
        </div>
        <div>
          <label class="text-gray-500 text-sm font-bold">Teléfono:</label>
          <p class="text-gray-800 text-lg">{{ therapist.phone }}</p>
        </div>
        <div>
          <label class="text-gray-500 text-sm font-bold">Especialidad:</label>
          <p class="text-gray-800 text-lg">{{ therapist.specialty }}</p>
        </div>
      </div>
      <div class="flex justify-end mt-8">
        <button type="button" @click="$emit('close')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Cerrar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  therapist: Object
});

const emit = defineEmits(['close']);
</script>
