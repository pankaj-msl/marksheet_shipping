<template>
    <Bar :data="chartData" :options="chartOptions" v-if="showChart" />
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';


const props = defineProps({
    examCycleData: {
        type: Object,
        required: true,
    }
});

// Register the necessary Chart.js components
Chart.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const showChart = ref(false);

// Reactive object for chart data
const chartData = reactive({
  labels: ['Pendings', 'Shipped', 'Delivered'],
  datasets: [
    {
      label: 'Documents Status',
      data: [0, 0, 0], // Initial data, will be updated after fetching from backend
      backgroundColor: ['#B70404', '#FFC100', '#2EAC6D'],
      hoverBackgroundColor: ['#3e95cd', '#8e5ea2', '#3cba9f'],
      borderWidth: 1,
    },
  ],
});

// Chart options
const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      display: true,
      position: 'top',
    },
    title: {
      display: true,
      text: 'Documents Status for Exam Cycle',
      position: 'bottom',
    },
    datalabels: {
            display: true,
            color: '#fff', // Customize the text color
            anchor: 'center', // Position of the label
            align: 'center',  // Alignment of the label
            formatter: (value, context) => {
                // Include the label (title) and the value
                const label = context.chart.data.labels[context.dataIndex];
                return `${label}: ${value}`; // Format: "Title: Value"
            },
            font: {
                weight: 'bold',
            },
        },
  },
});


watch(
  () => props.examCycleData,
  (newVal) => {
    updateChart(newVal);
  }
);

const updateChart = (examCycle) => {
  chartData.datasets[0].data = [examCycle.pendings, examCycle.shipped, examCycle.delivered];
  showChart.value = false; // Reset chart rendering state
  setTimeout(() => {
    showChart.value = true; // Re-render chart with updated data
  }, 0);
};


</script>