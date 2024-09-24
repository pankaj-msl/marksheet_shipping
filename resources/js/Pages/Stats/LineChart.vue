<template>
  <div>
    <!-- Render the ApexChart with reactive chart options and series data -->
    <apexchart type="line" :options="chartOptions" :series="examCycleTimeline.series" v-if="showChart" />
  </div>
</template>

<script setup>
import { ref, watch} from 'vue';
import axios from 'axios';

const examCycleTimeline = ref({
    categories: [],
    series: [],
})

let showChart = ref(false);

// Reactive configuration for the ApexChart
const chartOptions = {
  chart: {
    type: 'line',
    height: 350,
    zoom: {
      enabled: false,
    },
  },
  dataLabels: {
    enabled: true,
  },
  stroke: {
    curve: 'smooth',
  },
  title: {
    text: 'Document Status Over Exam Cycles',
    align: 'left',
  },
  xaxis: {
    categories: [], // This will be updated with exam cycle labels
  },
  yaxis: {
    title: {
      text: 'Count',
    },
  },
  tooltip: {
    y: {
      formatter: (val) => `${val} documents`,
    },
  },
};

// Watch for changes in the exam cycle timeline data and update the chart options
watch(() => examCycleTimeline.value, () => { 
    // chartOptions.xaxis.categories = examCycleTimeline.categories;
    chartOptions.series = examCycleTimeline.series;
});

const fetchExamCycleTimeline = () => {
      axios.get('/dashboard/exam_cycle/timeline')
       .then(response => {
        console.log("response: ", response);
        chartOptions.xaxis.categories = response.data.categories;
        examCycleTimeline.value.series = response.data.series;
        console.log("Exam Cycle Timeline Data2:", chartOptions.xaxis.categories);
        showChart.value = true; // Display the chart after data is fetched and updated
       })
       .catch(error => {
          console.error('Error fetching exam cycle timeline:', error);
        });
        
    }

fetchExamCycleTimeline();
</script>
