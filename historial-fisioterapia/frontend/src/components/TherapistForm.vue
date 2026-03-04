<template>
  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-40">
    <div class="relative mx-auto p-8 border w-full max-w-lg shadow-lg rounded-md bg-white">
      <h3 class="text-2xl font-bold mb-4">{{ therapist ? 'Editar Terapeuta' : 'Nuevo Terapeuta' }}</h3>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
          <input type="text" id="name" v-model="formData.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
          <input type="email" id="email" v-model="formData.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
          <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Teléfono:</label>
          <input type="tel" id="phone" v-model="formData.phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
          <label for="specialty" class="block text-gray-700 text-sm font-bold mb-2">Especialidad:</label>
          <select id="specialty" v-model="formData.specialty" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option>Fisioterapia Deportiva</option>
            <option>Fisioterapia Neurológica</option>
            <option>Fisioterapia Pediátrica</option>
            <option>Fisioterapia Geriátrica</option>
            <option>Terapia Manual</option>
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
  therapist: Object
});

const emit = defineEmits(['close', 'save']);

const formData = ref({
  name: '',
  email: '',
  phone: '',
  specialty: 'Terapia Manual'
});

watch(() => props.therapist, (newVal) => {
  if (newVal) {
    formData.value = { ...newVal };
  } else {
    formData.value = { name: '', email: '', phone: '', specialty: 'Terapia Manual' };
  }
}, { immediate: true });

const handleSubmit = () => {
  emit('save', formData.value);
};
</script>
