<template>
  <div class="bg-white p-4 rounded-lg shadow-sm">
    <h2 class="text-lg font-semibold">Coûts Opérationnels</h2>
    <p class="text-sm text-gray-500">Dépenses Mensuelles</p>
    <div class="mt-4">
      <Bar :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const chartData = ref({
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
  datasets: [
    {
      label: 'Dépenses',
      backgroundColor: '#10B981',
      data: [5000, 4800, 6000, 7500, 5500, 6200],
    },
  ],
});

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    y: {
      beginAtZero: true,
    },
  },
});
</script>

