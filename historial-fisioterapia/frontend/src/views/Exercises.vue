<template>
  <div class="p-4 sm:p-8 bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
      <h1 class="text-3xl header-text-style mb-4 sm:mb-0">Biblioteca de Ejercicios</h1>
      <button @click="openForm()" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-md flex items-center">
        <PlusIcon class="h-5 w-5 mr-2" />
        Nuevo Ejercicio
      </button>
    </div>

    <!-- Search and Filters -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="text" v-model="searchQuery" placeholder="Buscar por nombre..." class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <select v-model="selectedCategory" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          <option value="">Todas las categorías</option>
          <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
        </select>
      </div>
    </div>

    <!-- Exercises Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-x-auto border-2 border-blue-400">
      <table class="w-full table-auto border border-gray-400">
        <thead class="border-b-2 border-gray-200 bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-gray-200">Nombre</th>
            <th class="px-4 py-3 text-left text-gray-600 font-semibold hidden md:table-cell bg-gradient-to-l from-gray-100 to-gray-200">Categoría</th>
            <th class="px-4 py-3 text-left text-gray-600 font-semibold bg-gradient-to-l from-gray-100 to-gray-200">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="paginatedExercises.length === 0">
            <td colspan="3" class="text-center py-4 bg-gradient-to-l from-gray-100 to-white">No se encontraron ejercicios.</td>
          </tr>
          <tr v-for="exercise in paginatedExercises" :key="exercise.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">{{ exercise.name }}</td>
            <td class="px-4 py-3 hidden md:table-cell bg-gradient-to-l from-gray-100 to-white">{{ exercise.category }}</td>
            <td class="px-4 py-3 bg-gradient-to-l from-gray-100 to-white">
              <div class="flex items-center space-x-3">
                <button @click="openDetail(exercise)" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded flex items-center">
                  <EyeIcon class="h-5 w-5 mr-2" />
                  Ver
                </button>
                <button @click="openForm(exercise)" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded flex items-center">
                  <PencilIcon class="h-5 w-5 mr-2" />
                  Editar
                </button>
                <button @click="deleteExercise(exercise.id)" class="bg-gradient-to-l from-blue-200 to-blue-400 hover:from-blue-300 hover:to-blue-500 text-white font-bold py-2 px-4 rounded flex items-center">
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
    <ExerciseForm 
      v-if="showForm"
      :exercise="selectedExercise"
      @close="showForm = false"
      @save="handleSave"
    />

    <!-- Detail Modal -->
    <ExerciseDetail 
      v-if="showDetail"
      :exercise="selectedExercise"
      @close="showDetail = false"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ExerciseForm from '../components/ExerciseForm.vue';
import ExerciseDetail from '../components/ExerciseDetail.vue';
import { PlusIcon, PencilIcon, TrashIcon, EyeIcon } from '@heroicons/vue/24/solid';

// Dummy Data
const exercises = ref([
  { id: 1, name: 'Sentadilla', description: 'Flexión de rodillas y cadera.', category: 'Fortalecimiento' },
  { id: 2, name: 'Estiramiento de isquiotibiales', description: 'Sentado, estirar una pierna y alcanzar el pie.', category: 'Estiramiento' },
  { id: 3, name: 'Plancha abdominal', description: 'Mantener el cuerpo recto apoyado en antebrazos y pies.', category: 'Fortalecimiento' },
  { id: 4, name: 'Caminata en el sitio', description: 'Elevar rodillas alternadamente.', category: 'Cardio' },
  { id: 5, name: 'Rotación de tobillos', description: 'Girar los tobillos en círculos.', category: 'Movilidad' },
  { id: 6, name: 'Equilibrio sobre una pierna', description: 'Mantenerse sobre un pie el mayor tiempo posible.', category: 'Equilibrio' },
  { id: 7, name: 'Puente de glúteos', description: 'Elevar la cadera desde el suelo.', category: 'Fortalecimiento' },
]);

const categories = ref([
  'Fortalecimiento',
  'Estiramiento',
  'Equilibrio',
  'Cardio',
  'Movilidad',
]);

// Search and Filter state
const searchQuery = ref('');
const selectedCategory = ref('');

// Pagination state
const currentPage = ref(1);
const itemsPerPage = ref(5);

// Modal state
const showForm = ref(false);
const showDetail = ref(false);
const selectedExercise = ref(null);

// Computed properties for filtering and pagination
const filteredExercises = computed(() => {
  let filtered = exercises.value;
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(e => e.name.toLowerCase().includes(query));
  }
  if (selectedCategory.value) {
    filtered = filtered.filter(e => e.category === selectedCategory.value);
  }
  return filtered;
});

const totalPages = computed(() => {
  return Math.ceil(filteredExercises.value.length / itemsPerPage.value);
});

const paginatedExercises = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredExercises.value.slice(start, end);
});

// Methods
const openForm = (exercise = null) => {
  selectedExercise.value = exercise;
  showForm.value = true;
};

const openDetail = (exercise) => {
  selectedExercise.value = exercise;
  showDetail.value = true;
};

const handleSave = (exerciseData) => {
  if (exerciseData.id) {
    const index = exercises.value.findIndex(e => e.id === exerciseData.id);
    if (index !== -1) {
      exercises.value[index] = exerciseData;
    }
  } else {
    exerciseData.id = Date.now();
    exercises.value.push(exerciseData);
  }
  showForm.value = false;
};

const deleteExercise = (id) => {
  if (window.confirm('¿Estás seguro de que quieres eliminar este ejercicio?')) {
    exercises.value = exercises.value.filter(e => e.id !== id);
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
