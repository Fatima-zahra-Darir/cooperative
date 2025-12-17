<template>
  <div class="bg-white p-4 rounded-lg shadow-sm">
    <h2 class="text-lg font-semibold">Aperçu Financier</h2>
    <p class="text-sm text-gray-500">Croissance des revenus (Jan - Dec)</p>
    <div class="mt-4">
      <Line :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement);

const chartData = ref({
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  datasets: [
    {
      label: 'Revenu',
      backgroundColor: '#10B981',
      borderColor: '#10B981',
      data: [10000, 12000, 15000, 13000, 16000, 18000, 20000, 22000, 21000, 23000, 25000, 27000],
      fill: false,
      tension: 0.3
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

