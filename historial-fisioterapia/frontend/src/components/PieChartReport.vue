<template>
  <div class="h-64">
    <Plotly :data="plotlyData" :layout="plotlyLayout" :display-mode-bar="false"></Plotly>
  </div>
</template>

<script setup>
import { defineProps, computed } from 'vue';
import Plotly from '@aurium/vue-plotly';

const props = defineProps({
  chartData: {
    type: Object,
    required: true,
  },
  options: {
    type: Object,
    default: () => ({}),
  },
});

const plotlyData = computed(() => {
  // Transform chartData to Plotly's format for a pie chart
  return [{
    values: props.chartData.datasets[0].data,
    labels: props.chartData.labels,
    type: 'pie',
    hole: 0.4, // Example for a donut chart
    marker: {
      colors: props.chartData.datasets[0].backgroundColor
    },
    // For 3D effect, Plotly's pie chart doesn't have a direct '3d' property like bar.
    // We might need to use a different trace type or a custom approach for true 3D pie.
    // For now, this will render a 2D pie chart with Plotly.
  }];
});

const plotlyLayout = computed(() => {
  return {
    title: props.options.title || '',
    height: 256, // Corresponds to h-64 (64 * 4 = 256px)
    showlegend: true,
    margin: { t: 40, b: 40, l: 40, r: 40 },
    // For 3D, Plotly uses 'scene' for 3D layouts, but not directly for pie charts.
    // This will be relevant for bar charts.
  };
});
</script>

<style scoped>
/* Add any specific styles for the PieChartReport component here */
</style>