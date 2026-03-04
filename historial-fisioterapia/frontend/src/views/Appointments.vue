<template>
  <div class="p-8 bg-gray-100 min-h-screen">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl header-text-style">Gestión de Citas</h1>
      <button @click="openForm()" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-md flex items-center">
        <PlusIcon class="h-5 w-5 mr-2" />
        Nueva Cita
      </button>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 border-2 border-blue-400">
      <table class="w-full table-auto border border-gray-400">
        <thead class="border-b-2 border-gray-200">
          <tr>
            <th class="px-4 py-2 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-white">Paciente</th>
            <th class="px-4 py-2 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-white">Fecha</th>
            <th class="px-4 py-2 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-white">Hora</th>
            <th class="px-4 py-2 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-white">Estado</th>
            <th class="px-4 py-2 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-white">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="appointment in appointments" :key="appointment.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">{{ appointment.patient }}</td>
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">{{ appointment.date }}</td>
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">{{ appointment.time }}</td>
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">
              <span :class="getStatusClass(appointment.status)" class="px-2 py-1 text-xs font-bold rounded-full">
                {{ appointment.status }}
              </span>
            </td>
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">
              <button @click="openForm(appointment)" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded mr-2 flex items-center">
                <PencilIcon class="h-5 w-5 mr-2" />
                Editar
              </button>
              <button @click="deleteAppointment(appointment.id)" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded flex items-center">
                <TrashIcon class="h-5 w-5 mr-2" />
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <AppointmentForm 
      v-if="showForm"
      :appointment="selectedAppointment"
      @close="showForm = false"
      @save="handleSave"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import AppointmentForm from '../components/AppointmentForm.vue';
import { PlusIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/solid';

const appointments = ref([
  { id: 1, patient: 'Juan Pérez', date: '2025-09-20', time: '10:00 AM', status: 'Confirmada' },
  { id: 2, patient: 'Ana Gómez', date: '2025-09-20', time: '11:00 AM', status: 'Pendiente' },
  { id: 3, patient: 'Carlos Sánchez', date: '2025-09-21', time: '09:30 AM', status: 'Cancelada' },
  { id: 4, patient: 'Laura Fernández', date: '2025-09-22', time: '02:00 PM', status: 'Confirmada' },
]);

const showForm = ref(false);
const selectedAppointment = ref(null);

const openForm = (appointment = null) => {
  selectedAppointment.value = appointment;
  showForm.value = true;
};

const handleSave = (appointmentData) => {
  if (appointmentData.id) {
    // Update existing appointment
    const index = appointments.value.findIndex(a => a.id === appointmentData.id);
    if (index !== -1) {
      appointments.value[index] = appointmentData;
    }
  } else {
    // Add new appointment
    appointmentData.id = Date.now(); // simple id generation
    appointments.value.push(appointmentData);
  }
  showForm.value = false;
};

const deleteAppointment = (id) => {
  if (window.confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
    appointments.value = appointments.value.filter(a => a.id !== id);
  }
};

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

<style scoped>
/* Specific styles for Appointments view */
</style>
