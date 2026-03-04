<template>
  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="relative mx-auto p-8 border w-full max-w-lg shadow-lg rounded-md bg-white">
      <h3 class="text-2xl font-bold mb-4">{{ appointment ? 'Editar Cita' : 'Nueva Cita' }}</h3>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="patient" class="block text-gray-700 text-sm font-bold mb-2">Paciente:</label>
          <input type="text" id="patient" v-model="formData.patient" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Fecha:</label>
            <input type="date" id="date" v-model="formData.date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
          </div>
          <div>
            <label for="time" class="block text-gray-700 text-sm font-bold mb-2">Hora:</label>
            <input type="time" id="time" v-model="formData.time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
          </div>
        </div>
        <div class="mb-4">
          <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
          <select id="status" v-model="formData.status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option>Pendiente</option>
            <option>Confirmada</option>
            <option>Cancelada</option>
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
  appointment: Object
});

const emit = defineEmits(['close', 'save']);

const formData = ref({
  patient: '',
  date: '',
  time: '',
  status: 'Pendiente'
});

watch(() => props.appointment, (newVal) => {
  if (newVal) {
    formData.value = { ...newVal };
  } else {
    formData.value = { patient: '', date: '', time: '', status: 'Pendiente' };
  }
}, { immediate: true });

const handleSubmit = () => {
  emit('save', formData.value);
};
</script>
