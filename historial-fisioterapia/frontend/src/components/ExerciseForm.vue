<template>
  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-40">
    <div class="relative mx-auto p-8 border w-full max-w-lg shadow-lg rounded-md bg-white">
      <h3 class="text-2xl font-bold mb-4">{{ exercise ? 'Editar Ejercicio' : 'Nuevo Ejercicio' }}</h3>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre del Ejercicio:</label>
          <input type="text" id="name" v-model="formData.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
          <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
          <textarea id="description" v-model="formData.description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div class="mb-4">
          <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
          <select id="category" v-model="formData.category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option>Fortalecimiento</option>
            <option>Estiramiento</option>
            <option>Equilibrio</option>
            <option>Cardio</option>
            <option>Movilidad</option>
          </select>
        </div>
        <div class="flex justify-end space-x-4">
          <button type="button" @click="$emit('close')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Cancelar
          </button>
          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  exercise: Object
});

const emit = defineEmits(['close', 'save']);

const formData = ref({
  name: '',
  description: '',
  category: 'Fortalecimiento'
});

watch(() => props.exercise, (newVal) => {
  if (newVal) {
    formData.value = { ...newVal };
  } else {
    formData.value = { name: '', description: '', category: 'Fortalecimiento' };
  }
}, { immediate: true });

const handleSubmit = () => {
  emit('save', formData.value);
};
</script>
