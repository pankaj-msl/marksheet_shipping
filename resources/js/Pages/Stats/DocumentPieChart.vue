<template>     
    <div v-if="showChart">
        <Pie :data="chartData" :options="chartOptions" />
    </div> 
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import { Pie } from 'vue-chartjs';
import { Chart, registerables, Title, Tooltip, Legend, ArcElement } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

const props = defineProps({
    summaryData: {
        type: Object,
        required: true,
    }
});

let summary = reactive(props.summaryData);
console.log(props.summaryData);

// Register Chart.js components
Chart.register(...registerables, ChartDataLabels, Title, Tooltip, Legend, ArcElement);

const showChart = ref(false);

// Data for the chart
const chartData = reactive({
    labels: ['Pendings', 'Shipped', 'Delivered'],
    datasets: [
        {
            label: 'Documents Status',
            data: [0, 0, 0],
            backgroundColor: ['#B70404', '#FFC100', '#2EAC6D'],
            hoverBackgroundColor: ['#3e95cd', '#8e5ea2', '#3cba9f'],
        },
    ],
});

// Chart options
const chartOptions = ref({
    responsive: true,
    plugins: {
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Overall Documents Status',
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


const fetchChart = () => {
  chartData.datasets[0].data = [summary.pendings, summary.shipped, summary.delivered];
  showChart.value = true;
};

watch(() => props.summaryData, (newVal) =>{
  summary = newVal;
  fetchChart();
})
</script>