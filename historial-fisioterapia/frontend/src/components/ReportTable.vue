<template>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200">
      <thead>
        <tr>
          <th v-for="column in columns" :key="column.key" class="py-2 px-4 border-b text-left">
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in data" :key="index">
          <td v-for="column in columns" :key="column.key" class="py-2 px-4 border-b">
            {{ row[column.key] }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  columns: {
    type: Array,
    required: true,
  },
  data: {
    type: Array,
    required: true,
  },
});
</script>

<style scoped>
/* Add any specific styles for the ReportTable component here */
</style>
