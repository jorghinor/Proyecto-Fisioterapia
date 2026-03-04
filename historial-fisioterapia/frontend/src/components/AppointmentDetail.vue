<template>
  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-40">
    <div class="relative mx-auto p-8 border w-full max-w-lg shadow-lg rounded-md bg-white">
      <h3 class="text-2xl font-bold mb-6">Detalles de la Cita</h3>
      <div v-if="appointment" class="space-y-4">
        <div>
          <label class="text-gray-500 text-sm font-bold">Paciente:</label>
          <p class="text-gray-800 text-lg">{{ appointment.patient }}</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="text-gray-500 text-sm font-bold">Fecha:</label>
            <p class="text-gray-800 text-lg">{{ appointment.date }}</p>
          </div>
          <div>
            <label class="text-gray-500 text-sm font-bold">Hora:</label>
            <p class="text-gray-800 text-lg">{{ appointment.time }}</p>
          </div>
        </div>
        <div>
          <label class="text-gray-500 text-sm font-bold">Estado:</label>
          <p class="text-gray-800 text-lg">
            <span :class="getStatusClass(appointment.status)" class="px-3 py-1 text-sm font-bold rounded-full">
              {{ appointment.status }}
            </span>
          </p>
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
  appointment: Object
});

const emit = defineEmits(['close']);

const getStatusClass = (status) => {
  switch (status) {
    case 'Confirmada':
      return 'bg-green-200 text-green-800';
    case 'Pendiente':
      return 'bg-yellow-200 text-yellow-800';
    case 'Cancelada':
      return 'bg-red-200 text-red-800';
    default:
      return 'bg-gray-200 text-gray-800';
  }
};
</script>
