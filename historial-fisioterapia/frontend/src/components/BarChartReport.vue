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
  const labels = props.chartData.labels;
  const data = props.chartData.datasets[0].data;
  const color = props.chartData.datasets[0].backgroundColor;

  // For 3D bars, we'll use scatter3d and simulate bars with markers
  const x = labels.map((_, i) => i); // X-coordinates for each bar
  const y = labels.map(() => 0); // Y-coordinates (can be adjusted for depth)
  const z = data; // Z-coordinates (height of the bars)

  return [{
    x: x,
    y: y,
    z: z,
    type: 'scatter3d',
    mode: 'markers',
    marker: {
      size: 10, // Adjust size to represent bar width
      color: color,
      symbol: 'cube', // Use cube symbol to simulate bars
      opacity: 0.8,
      sizemode: 'absolute',
      sizeref: 0.5, // Adjust to control actual size
    },
    name: props.chartData.datasets[0].label,
  }];
});

const plotlyLayout = computed(() => {
  return {
    title: props.options.title || '',
    height: 256, // Corresponds to h-64 (64 * 4 = 256px)
    showlegend: true,
    margin: { t: 40, b: 40, l: 40, r: 40 },
    scene: {
      xaxis: { title: 'Therapist' },
      yaxis: { title: 'Depth' }, // Can be adjusted or hidden
      zaxis: { title: 'Appointments' },
      camera: {
        eye: { x: 1.25, y: 1.25, z: 1.25 } // Adjust camera angle for 3D perspective
      }
    }
  };
});
</script>

<style scoped>
/* Add any specific styles for the BarChartReport component here */
</style>