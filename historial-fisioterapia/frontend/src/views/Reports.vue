<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4 reports-dashboard-effect">Reports Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Patients Summary (Table)</h2>
        <ReportTable :data="patientTableData" :columns="patientTableColumns" />
      </div>
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Appointments by Status (Pie Chart)</h2>
        <PieChartReport :chartData="appointmentStatusChartData" :options="{ title: 'Appointments by Status' }" />
      </div>
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Therapist Workload (Bar Chart)</h2>
        <BarChartReport :chartData="therapistWorkloadChartData" :options="{ title: 'Therapist Workload' }" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ReportTable from '../components/ReportTable.vue';
import PieChartReport from '../components/PieChartReport.vue';
import BarChartReport from '../components/BarChartReport.vue';

// Mock Data for Tables
const patientTableColumns = [
  { key: 'id', label: 'ID' },
  { key: 'name', label: 'Name' },
  { key: 'age', label: 'Age' },
  { key: 'condition', label: 'Condition' },
];

const patientTableData = ref([
  { id: 1, name: 'Alice Smith', age: 30, condition: 'Knee Pain' },
  { id: 2, name: 'Bob Johnson', age: 45, condition: 'Back Pain' },
  { id: 3, name: 'Charlie Brown', age: 25, condition: 'Shoulder Injury' },
  { id: 4, name: 'Diana Prince', age: 50, condition: 'Neck Strain' },
]);

// Mock Data for Charts
const appointmentStatusChartData = {
  labels: ['Pending', 'Completed', 'Cancelled'],
  datasets: [
    {
      backgroundColor: ['#41B883', '#E46651', '#00D8FF'],
      data: [40, 20, 10]
    }
  ]
};

const therapistWorkloadChartData = {
  labels: ['Dr. Smith', 'Dr. Jones', 'Dr. Williams'],
  datasets: [
    {
      label: 'Number of Appointments',
      backgroundColor: '#f87979',
      data: [15, 10, 8]
    }
  ]
};

</script>

<style scoped>
.reports-dashboard-effect {
  color: #ffffff; /* White text color */
  text-shadow:
    1px 1px 0px #1e88e5,
    2px 2px 0px #1565c0,
    3px 3px 0px #0d47a1,
    4px 4px 5px rgba(0, 0, 0, 0.5);
}
</style>
