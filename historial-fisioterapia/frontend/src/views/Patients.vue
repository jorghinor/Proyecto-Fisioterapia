<template>
  <div class="p-4">
    <h1 class="text-3xl header-text-style mb-4 sm:mb-0">Pacientes</h1>

    <!-- Formulario para agregar/editar pacientes -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
      <h2 class="text-xl font-semibold mb-2">{{ editingPatientIndex === null ? 'Agregar Nuevo Paciente' : 'Editar Paciente' }}</h2>
      <form @submit.prevent="savePatient" class="needs-validation" novalidate>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-group">
            <label for="name" class="form-label">Nombre</label>
            <input v-model="patientForm.name" id="name" placeholder="Nombre" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input v-model="patientForm.email" id="email" type="email" placeholder="Email" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="phone" class="form-label">Teléfono</label>
            <input v-model="patientForm.phone" id="phone" placeholder="Teléfono" class="form-control">
          </div>
          <div class="form-group">
            <label for="dob" class="form-label">Fecha de Nacimiento</label>
            <input v-model="patientForm.dob" id="dob" type="date" placeholder="Fecha de Nacimiento" class="form-control">
          </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4">
          {{ editingPatientIndex === null ? 'Agregar Paciente' : 'Guardar Cambios' }}
        </button>
        <button v-if="editingPatientIndex !== null" @click="cancelEdit" type="button" class="btn btn-secondary mt-4 ml-2">
          Cancelar
        </button>
      </form>
    </div>

    <!-- Controles de Búsqueda y Filtro -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input v-model="searchQuery" placeholder="Buscar por nombre..." class="form-control">
            <input v-model="filterDobStart" type="date" placeholder="Fecha de Nac. Desde" class="form-control">
            <input v-model="filterDobEnd" type="date" placeholder="Fecha de Nac. Hasta" class="form-control">
        </div>
    </div>

    <!-- Tabla de pacientes -->
    <div class="bg-white p-4 rounded-lg shadow-md">
      <h2 class="text-xl header-text-style mb-2">Lista de Pacientes</h2>
      <table class="table table-striped border border-gray-400">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Email</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="patient in paginatedPatients" :key="patient.id">
            <td class="bg-gradient-to-l from-gray-100 to-white">{{ patient.name }}</td>
            <td class="bg-gradient-to-l from-gray-100 to-white">{{ patient.email }}</td>
            <td class="bg-gradient-to-l from-gray-100 to-white">{{ patient.phone }}</td>
            <td class="bg-gradient-to-l from-gray-100 to-white">{{ patient.dob }}</td>
            <td class="bg-gradient-to-l from-gray-100 to-white">
              <button @click="viewPatient(patient)" class="btn btn-info btn-sm me-2">
                <EyeIcon class="h-5 w-5"/>
              </button>
              <button @click="editPatient(patient)" class="btn btn-warning btn-sm me-2">
                <PencilIcon class="h-5 w-5"/>
              </button>
              <button @click="deletePatient(patient.id)" class="btn btn-danger btn-sm">
                <TrashIcon class="h-5 w-5"/>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- Controles de Paginación -->
        <div class="mt-4 flex justify-between items-center">
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a class="page-link" href="#" @click.prevent="prevPage">Anterior</a>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                  <a class="page-link" href="#" @click.prevent="currentPage = page">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                  <a class="page-link" href="#" @click.prevent="nextPage">Siguiente</a>
                </li>
              </ul>
            </nav>
            <div class="text-sm text-gray-600">
                Mostrando {{ paginatedPatients.length }} de {{ filteredPatients.length }} pacientes
            </div>
        </div>
    </div>

    <!-- Modal para ver paciente -->
    <div v-if="viewingPatient" class="modal fade show" style="display: block;" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detalles del Paciente</h5>
            <button type="button" class="btn-close" @click="closeViewModal"></button>
          </div>
          <div class="modal-body">
            <p><strong>Nombre:</strong> {{ viewingPatient.name }}</p>
            <p><strong>Email:</strong> {{ viewingPatient.email }}</p>
            <p><strong>Teléfono:</strong> {{ viewingPatient.phone }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ viewingPatient.dob }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeViewModal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="viewingPatient" class="modal-backdrop fade show"></div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { PencilIcon, TrashIcon, EyeIcon } from '@heroicons/vue/24/solid';

const patients = ref([
  { id: 1, name: 'Juan Perez', email: 'juan@example.com', phone: '123456789', dob: '1990-01-15' },
  { id: 2, name: 'Maria Lopez', email: 'maria@example.com', phone: '987654321', dob: '1985-05-20' },
  { id: 3, name: 'Carlos Garcia', email: 'carlos@example.com', phone: '555555555', dob: '1992-08-10' },
  { id: 4, name: 'Ana Martinez', email: 'ana@example.com', phone: '111222333', dob: '1988-12-01' },
  { id: 5, name: 'Luis Rodriguez', email: 'luis@example.com', phone: '444555666', dob: '1995-03-25' },
]);

const patientForm = ref({
  id: null,
  name: '',
  email: '',
  phone: '',
  dob: ''
});

const editingPatientIndex = ref(null);
const searchQuery = ref('');
const filterDobStart = ref('');
const filterDobEnd = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(5);
const viewingPatient = ref(null);

const filteredPatients = computed(() => {
  return patients.value.filter(patient => {
    const nameMatch = patient.name.toLowerCase().includes(searchQuery.value.toLowerCase());
    const dob = new Date(patient.dob);
    const start = filterDobStart.value ? new Date(filterDobStart.value) : null;
    const end = filterDobEnd.value ? new Date(filterDobEnd.value) : null;
    const dobMatch = (!start || dob >= start) && (!end || dob <= end);
    return nameMatch && dobMatch;
  });
});

const totalPages = computed(() => {
    return Math.ceil(filteredPatients.value.length / itemsPerPage.value)
});

const paginatedPatients = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return filteredPatients.value.slice(start, end);
});

const savePatient = () => {
  if (editingPatientIndex.value === null) {
    // Agregar nuevo paciente
    patientForm.value.id = Date.now(); // simple id
    patients.value.push({ ...patientForm.value });
  } else {
    // Guardar cambios
    const index = patients.value.findIndex(p => p.id === patientForm.value.id);
    if(index !== -1) {
        patients.value[index] = { ...patientForm.value };
    }
  }
  resetForm();
};

const editPatient = (patient) => {
    patientForm.value = { ...patient };
    editingPatientIndex.value = patient.id;
};

const cancelEdit = () => {
    resetForm();
}

const deletePatient = (patientId) => {
  const index = patients.value.findIndex(p => p.id === patientId);
  if(index !== -1) {
    patients.value.splice(index, 1);
  }
};

const resetForm = () => {
    patientForm.value = { id: null, name: '', email: '', phone: '', dob: '' };
    editingPatientIndex.value = null;
}

const nextPage = () => {
    if(currentPage.value < totalPages.value) {
        currentPage.value++;
    }
}

const prevPage = () => {
    if(currentPage.value > 1) {
        currentPage.value--;
    }
}

const viewPatient = (patient) => {
  viewingPatient.value = patient;
}

const closeViewModal = () => {
  viewingPatient.value = null;
}

</script>

<style scoped>
@import 'bootstrap/dist/css/bootstrap.min.css';

.form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.btn {
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.btn-primary {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-info {
    color: #000;
    background-color: #0dcaf0;
    border-color: #0dcaf0;
}

.btn-warning {
    color: #000;
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-sm {
    padding: .25rem .5rem;
    font-size: .875rem;
    border-radius: .2rem;
}

.me-2 {
    margin-right: .5rem!important;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1055;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    outline: 0;
}

.modal-dialog {
    position: relative;
    width: auto;
    margin: .5rem;
    pointer-events: none;
}

@media (min-width: 576px) {
    .modal-dialog {
        max-width: 500px;
        margin: 1.75rem auto;
    }
}

.modal.fade .modal-dialog {
    transition: transform .3s ease-out;
    transform: translate(0,-50px);
}

.modal.show .modal-dialog {
    transform: none;
}

.modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: .3rem;
    outline: 0;
}

.modal-header {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(.3rem - 1px);
    border-top-right-radius: calc(.3rem - 1px);
}

.modal-title {
    margin-bottom: 0;
    line-height: 1.5;
}

.btn-close {
    box-sizing: content-box;
    width: 1em;
    height: 1em;
    padding: .25em .25em;
    color: #000;
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    border: 0;
    border-radius: .25rem;
    opacity: .5;
}

.modal-body {
    position: relative;
    flex: 1 1 auto;
    padding: 1rem;
}

.modal-footer {
    display: flex;
    flex-wrap: wrap;
    flex-shrink: 0;
    align-items: center;
    justify-content: flex-end;
    padding: .75rem;
    border-top: 1px solid #dee2e6;
    border-bottom-right-radius: calc(.3rem - 1px);
    border-bottom-left-radius: calc(.3rem - 1px);
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    width: 100vw;
    height: 100vh;
    background-color: #000;
}

.modal-backdrop.fade {
    opacity: 0;
}

.modal-backdrop.show {
    opacity: .5;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    vertical-align: top;
    border-color: #dee2e6;
}

.table-striped>tbody>tr:nth-of-type(odd)>* {
    --bs-table-accent-bg: var(--bs-table-striped-bg);
    color: var(--bs-table-striped-color);
}

.pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
}

.page-item:first-child .page-link {
    border-top-left-radius: .25rem;
    border-bottom-left-radius: .25rem;
}

.page-item:last-child .page-link {
    border-top-right-radius: .25rem;
    border-bottom-right-radius: .25rem;
}

.page-link {
    position: relative;
    display: block;
    padding: .375rem .75rem;
    color: #0d6efd;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}

.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>