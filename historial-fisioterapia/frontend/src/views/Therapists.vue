<template>
  <div class="p-4 sm:p-8 bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
      <h1 class="text-3xl header-text-style mb-4 sm:mb-0">Gestión de Terapeutas</h1>
      <button @click="openForm()" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-md flex items-center">
        <PlusIcon class="h-5 w-5 mr-2" />
        Nuevo Terapeuta
      </button>
    </div>

    <!-- Search and Filters -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="text" v-model="searchQuery" placeholder="Buscar por nombre o email..." class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <select v-model="selectedSpecialty" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          <option value="">Todas las especialidades</option>
          <option v-for="spec in specialties" :key="spec" :value="spec">{{ spec }}</option>
        </select>
      </div>
    </div>

    <!-- Therapists Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-x-auto border-2 border-blue-400">
      <table class="w-full table-auto border border-gray-400">
        <thead class="border-b-2 border-gray-200 bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-gray-200">Nombre</th>
            <th class="px-4 py-3 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-gray-200">Email</th>
            <th class="px-4 py-3 text-left text-gray-600 font-semibold hidden lg:table-cell bg-gradient-to-l from-gray-100 to-gray-200">Especialidad</th>
            <th class="px-4 py-3 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-gray-200">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="paginatedTherapists.length === 0">
            <td colspan="4" class="text-center py-4 bg-gradient-to-l from-gray-100 to-white">No se encontraron terapeutas.</td>
          </tr>
          <tr v-for="therapist in paginatedTherapists" :key="therapist.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">{{ therapist.name }}</td>
            <td class="px-4 py-3 hidden md:table-cell bg-gradient-to-l from-gray-100 to-white">{{ therapist.email }}</td>
            <td class="px-4 py-3 hidden lg:table-cell bg-gradient-to-l from-gray-100 to-white">{{ therapist.specialty }}</td>
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">
              <div class="flex items-center space-x-3">
                <button @click="openDetail(therapist)" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded flex items-center">
                  <EyeIcon class="h-5 w-5 mr-2" />
                  Ver
                </button>
                <button @click="openForm(therapist)" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded flex items-center">
                  <PencilIcon class="h-5 w-5 mr-2" />
                  Editar
                </button>
                <button @click="deleteTherapist(therapist.id)" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded flex items-center">
                  <TrashIcon class="h-5 w-5 mr-2" />
                  Eliminar
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-between items-center">
      <button @click="prevPage" :disabled="currentPage === 1" class="bg-white border border-gray-300 rounded-md py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50">
        Anterior
      </button>
      <span>Página {{ currentPage }} de {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="bg-white border border-gray-300 rounded-md py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50">
        Siguiente
      </button>
    </div>

    <!-- Form Modal -->
    <TherapistForm 
      v-if="showForm"
      :therapist="selectedTherapist"
      @close="showForm = false"
      @save="handleSave"
    />

    <!-- Detail Modal -->
    <TherapistDetail 
      v-if="showDetail"
      :therapist="selectedTherapist"
      @close="showDetail = false"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import TherapistForm from '../components/TherapistForm.vue';
import TherapistDetail from '../components/TherapistDetail.vue';
import { PlusIcon, PencilIcon, TrashIcon, EyeIcon } from '@heroicons/vue/24/solid';

// Dummy Data
const therapists = ref([
  { id: 1, name: 'Dr. Carlos Rivera', email: 'carlos.r@email.com', phone: '555-0101', specialty: 'Fisioterapia Deportiva' },
  { id: 2, name: 'Dra. Ana Torres', email: 'ana.t@email.com', phone: '555-0102', specialty: 'Fisioterapia Neurológica' },
  { id: 3, name: 'Dr. Luis Morales', email: 'luis.m@email.com', phone: '555-0103', specialty: 'Terapia Manual' },
  { id: 4, name: 'Dra. Sofia Castro', email: 'sofia.c@email.com', phone: '555-0104', specialty: 'Fisioterapia Pediátrica' },
  { id: 5, name: 'Dr. Javier Rojas', email: 'javier.r@email.com', phone: '555-0105', specialty: 'Fisioterapia Geriátrica' },
  { id: 6, name: 'Dra. Elena Peña', email: 'elena.p@email.com', phone: '555-0106', specialty: 'Fisioterapia Deportiva' },
  { id: 7, name: 'Dr. Mario Vargas', email: 'mario.v@email.com', phone: '555-0107', specialty: 'Terapia Manual' },
]);

const specialties = ref([
  'Fisioterapia Deportiva',
  'Fisioterapia Neurológica',
  'Fisioterapia Pediátrica',
  'Fisioterapia Geriátrica',
  'Terapia Manual',
]);

// Search and Filter state
const searchQuery = ref('');
const selectedSpecialty = ref('');

// Pagination state
const currentPage = ref(1);
const itemsPerPage = ref(5);

// Modal state
const showForm = ref(false);
const showDetail = ref(false);
const selectedTherapist = ref(null);

// Computed properties for filtering and pagination
const filteredTherapists = computed(() => {
  let filtered = therapists.value;
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(t => 
      t.name.toLowerCase().includes(query) || 
      t.email.toLowerCase().includes(query)
    );
  }
  if (selectedSpecialty.value) {
    filtered = filtered.filter(t => t.specialty === selectedSpecialty.value);
  }
  return filtered;
});

const totalPages = computed(() => {
  return Math.ceil(filteredTherapists.value.length / itemsPerPage.value);
});

const paginatedTherapists = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredTherapists.value.slice(start, end);
});

// Methods
const openForm = (therapist = null) => {
  selectedTherapist.value = therapist;
  showForm.value = true;
};

const openDetail = (therapist) => {
  selectedTherapist.value = therapist;
  showDetail.value = true;
};

const handleSave = (therapistData) => {
  if (therapistData.id) {
    const index = therapists.value.findIndex(t => t.id === therapistData.id);
    if (index !== -1) {
      therapists.value[index] = therapistData;
    }
  } else {
    therapistData.id = Date.now();
    therapists.value.push(therapistData);
  }
  showForm.value = false;
};

const deleteTherapist = (id) => {
  if (window.confirm('¿Estás seguro de que quieres eliminar a este terapeuta?')) {
    therapists.value = therapists.value.filter(t => t.id !== id);
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

</script>
