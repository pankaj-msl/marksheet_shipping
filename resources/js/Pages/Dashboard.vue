<template>
    <Header :data="{ client, admin }"></Header>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section>      
    <div>
      <!-- Statistics Cards Row -->
      <v-row class="my-6" align="center" justify="space-around">
        <!-- Documents Generated Card -->
        <v-col cols="12" md="4">
          <v-skeleton-loader
                v-if="loading"
                elevation="8"
                type="list-item-two-line"
                ></v-skeleton-loader>
          <v-card v-show="!loading" class="elevation-3 ooey-gooey text-white">
            <v-card-text class="d-flex align-center">
              <v-icon size="36" color="white" class="mr-3">mdi-file-document</v-icon>
              <div class="text-h6">Documents Generated: {{ generatedDocs }}</div>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- Total Students Card -->
        <v-col cols="12" md="4">
          <v-skeleton-loader
                v-if="loading"
                elevation="8"
                type="list-item-two-line"
                ></v-skeleton-loader>
          <v-card v-show="!loading" class="elevation-3 ooey-gooey text-white">
            <v-card-text class="d-flex align-center">
              <v-icon size="36" color="white" class="mr-3">mdi-school</v-icon>
              <div class="text-h6">Total Students: {{ students }}</div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <!-- Charts and Filters Section -->
      <v-sheet class="py-6 px-4 elevation-8 rounded lovely-pausam">
        
        <!-- ================================ skeleton loader ends here  ========================================= -->
        <v-row class="mb-4">
          <!-- Line Chart for Exam Cycle Timeline -->
          <v-col cols="12" md="6">
            <v-skeleton-loader
                v-if="loading"
                elevation="8"
                height="520"
                type="table-heading, list-item-two-line, image, table-tfoot"
                ></v-skeleton-loader>
            <v-sheet v-show="!loading" class="elevation-5 p-4 rounded dusty-clean">
              <!-- <LineChart :data="examCycleTimeline"></LineChart> -->
              <LineChart></LineChart>
            </v-sheet>
          </v-col>

          <!-- Calendar Image Card -->
          <v-col cols="12" md="3">
            <v-skeleton-loader
                v-if="loading"
                elevation="8"
                type="table-heading, list-item-two-line, image, table-tfoot"
                ></v-skeleton-loader>
            <v-card v-show="!loading" class="elevation-5">
              <v-table
                height="300px"
                fixed-header
                class="glass-table dusty-clean"
                :aria-describedby="'line-chart-table'"
            >
                <thead>
                <tr>
                    <th class="text-left font-weight-bold text-primary">Exam Cycle</th>
                    <th class="text-left font-weight-bold text-primary"><v-icon size="large" color="red-darken-4" icon="mdi-knob" class="mx-1"></v-icon>Pending</th>
                    <th class="text-left font-weight-bold text-primary"><v-icon size="large" color="warning" icon="mdi-truck" class="mx-1"></v-icon>Shipped</th>
                    <th class="text-left font-weight-bold text-primary"><v-icon size="large" color="green-darken-2" icon="mdi-check-decagram" class="mx-1"></v-icon>Delivered</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(category, index) in examCycleTimeline.categories" :key="index">
                    <td class="font-weight-bold text-green-darken-2">{{ category }}</td>
                    <td class="text-green-darken-2">{{ examCycleTimeline.series[0].data[index] }}</td>
                    <td class="text-green-darken-2">{{ examCycleTimeline.series[1].data[index] }}</td>
                    <td class="text-green-darken-2">{{ examCycleTimeline.series[2].data[index] }}</td>
                </tr>
                </tbody>
            </v-table>
            </v-card>
          </v-col>
          <v-col cols="12" md="3">
            <v-skeleton-loader
                v-if="loading"
                elevation="8"
                type="table-heading, list-item-two-line, image, table-tfoot"
                height="400"
                ></v-skeleton-loader>
            <div v-show="!loading">
                <v-card class="elevation-5">
                    <v-card class="elevation-3 my-3 mx-2 kale-salad">
                    <v-card-text class="d-flex align-center">
                        <v-icon size="large" color="red-darken-4" icon="mdi-knob" class="mx-1"></v-icon>
                    <div class="text-h6 text-teal-darken-4">Documents Pendings: {{ summaryStats.pendings }}</div>
                    </v-card-text>
                </v-card>
                    <v-card class="elevation-3 my-3 mx-2 kale-salad">
                    <v-card-text class="d-flex align-center">
                        <v-icon size="large" color="warning" icon="mdi-truck" class="mx-1"></v-icon>
                    <div class="text-h6 text-teal-darken-4">Documents Shipped: {{ summaryStats.shipped }}</div>
                    </v-card-text>
                </v-card>
                    <v-card class="elevation-3 my-3 mx-2 kale-salad">
                    <v-card-text class="d-flex align-center">
                        <v-icon size="large" color="green-darken-2" icon="mdi-check-decagram" class="mx-1"></v-icon>
                    <div class="text-h6 text-teal-darken-4">Documents Delivered: {{ summaryStats.delivered }}</div>
                    </v-card-text>
                    </v-card>
            </v-card>
            <v-card class="elevation-5 my-2">
                <v-card class="elevation-3 my-3 mx-2 lovely-lilly">
                    <v-card-text class="d-flex align-center">
                        <v-icon size="large" color="green-darken-2" icon="mdi-account-check" class="mx-1"></v-icon>
                    <div class="text-h6 text-teal-darken-4">Students Passed: {{ summaryStats.passed }}</div>
                    </v-card-text>
                </v-card>
                <v-card class="elevation-3 my-3 mx-2 lovely-lilly">
                    <v-card-text class="d-flex align-center">
                        <v-icon size="large" color="red-darken-4" icon="mdi-account-cancel" class="mx-1"></v-icon>
                    <div class="text-h6 text-teal-darken-4">Students Failed: {{ summaryStats.failed }}</div>
                    </v-card-text>
                </v-card>
            </v-card>
            </div>
          </v-col>
        </v-row>

        <v-divider class="my-4"></v-divider>

        <v-row class="mb-4">
          <!-- Pie Chart for Document Summary -->
          <v-col cols="12" md="4">
            <v-skeleton-loader
                v-if="loading"
                elevation="8"
                type="table-heading, list-item-two-line, image, table-tfoot"
                height="500"
                ></v-skeleton-loader>
            <v-sheet v-show="!loading" class="elevation-5 p-4 rounded dusty-clean">
              <DocumentPieChart :summaryData="summaryStats"></DocumentPieChart>
            </v-sheet>
          </v-col>

          <!-- Bar Chart with Exam Cycle Filter -->
          <v-col cols="12" md="8">
            <v-sheet class="elevation-5 p-4 rounded dusty-clean">
              <v-skeleton-loader
              v-if="loading"
              elevation="8"
              type="table-heading, list-item-two-line, image, table-tfoot"
              height="400"
              ></v-skeleton-loader>
              <v-row align="center" justify="space-between">
                <v-col v-show="!loading" cols="12" md="8">
                  <ExamCycleBarChart :examCycleData="examCycleStats"></ExamCycleBarChart>
                </v-col>
                <v-col v-show="!loading" cols="12" md="4">
                  <v-select
                    label="Select Exam Cycle"
                    v-model="selectedExamCycle"
                    :items="filterExamcycle"
                    variant="outlined"
                    color="primary"
                    prepend-icon="mdi-calendar"
                    class="w-100"
                  ></v-select>
                </v-col>
              </v-row>
            </v-sheet>
          </v-col>
        </v-row>
      </v-sheet>
    </div>
  </section>
    </main>
</template>

<script setup>
import Header from "./Layouts/Header.vue";
import DocumentPieChart from "./Stats/DocumentPieChart.vue";
import ExamCycleBarChart from "./Stats/ExamCycleBarChart.vue";
import { ref, watch, computed, reactive, onMounted } from "vue";
import axios from 'axios';
import LineChart from "./Stats/LineChart.vue";

// Define component props
defineProps({
    client: {
        type: Object,
        required: true,
    },
    admin: {
        type: Object,
        required: true,
    },
});

const generatedDocs = ref(0)
const students = ref(0);
const filterExamcycle = ref([]);
let selectedExamCycle = ref('Jun-2024');
const lineChartTable = ref([]);
let loading = ref(true);

setTimeout(() => {
        loading.value = false;
    }, 3000);

const summaryStats = ref({
    pendings: 0,
    shipped: 0,
    delivered: 0,
    passed: 0,
    failed: 0,
})
const examCycleStats = ref({
    pendings: 0,
    shipped: 0,
    delivered: 0,
    passed: 0,
    failed: 0,
})

const examCycleTimeline = reactive({
    categories: [],
    series: [],
})

watch(() => selectedExamCycle.value, (newVal) => {
    console.log("Selected Exam cycle is: ",newVal);
    fetchExamCycle(newVal);

})

// fetchExamCycle("Jun-2024");


const fetchSummary = async() => {
    const response = await fetch('/dashboard/summary');
    const data = await response.json();
    generatedDocs.value = data.generatedDocs;
    students.value = data.students;
}

const fetchSummaryStats = async () => {
    try {
        const response = await fetch('/dashboard/summary/stats');
        const { pendings, shipped, delivered, passed, failed } = await response.json();

        summaryStats.value = { pendings, shipped, delivered, passed, failed };
        console.log("Summary Stats Data:", summaryStats.value);
        
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

const fetchExamCycle = (exam_cycle_) => {  
    axios.get('/dashboard/exam_cycle/stats', {
    params: {
      exam_cycle: exam_cycle_, // pass the exam_cycle as a query parameter
    },
  })
    .then(response => {
        const { pendings, shipped, delivered, passed, failed } = response.data;
        examCycleStats.value = { pendings, shipped, delivered, passed, failed };
        console.log("Exam Cycle DAta:", examCycleStats.value);
    })  
    .catch((error) => {
         console.error(error);
     });
}

const fetchExamCycleTimeline = async() => {
    // Fetch exam cycle timeline data here
    try{
        const response = await fetch('/dashboard/exam_cycle/timeline');
        const data = await response.json();
        examCycleTimeline.categories = data.categories;
        examCycleTimeline.series = data.series;
        lineChartTable.value = data.table; // Populate the table with data for line chart
        console.log("Exam Cycle Timeline Data:", data);
    }
    catch(error){
        console.error('Error fetching exam cycle timeline data:', error);
    }
}

const populateExamCycle = async() => {
    // Populate exam cycle options here
    try{
        const response = await fetch('/dashboard/populateExamCycle');
        const data = await response.json();
        filterExamcycle.value = data.exam_cycles;
        console.log("Exam Cycle Options:", filterExamcycle.value);
    }
    catch(error){
        console.error('Error fetching exam cycle options:', error);
    }
}


populateExamCycle();
fetchSummary();
fetchSummaryStats();
// fetchExamCycle();
fetchExamCycle("Jun-2024");
fetchExamCycleTimeline();
</script>

<style scoped>
.section {
  background-color: #f4f6f9; /* Light background for contrast */
}

.v-card {
  border-radius: 12px; /* Rounded corners for cards */
}

.v-sheet {
  border-radius: 12px; /* Rounded corners for sheets */
}

.text-h6 {
  font-weight: bold; /* Make text bold for emphasis */
}

.elevation-1, .elevation-3 {
  transition: box-shadow 0.3s ease; /* Smooth hover effect */
}

.elevation-1:hover, .elevation-3:hover {
  box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1); /* Hover shadow effect */
}

.disco-club {
    background: linear-gradient(90deg, #FC466B 0%, #3F5EFB 100%);
}

.ooey-gooey {
    background: linear-gradient(90deg, #0700b8 0%, #00ff88 100%);
}

.kale-salad {
    background: linear-gradient(90deg, #00C9FF 0%, #92FE9D 100%);
}

.vital-ocean {
    background: linear-gradient(90deg, #1CB5E0 0%, #000851 100%);
}

.lovely-lilly {
    background: linear-gradient(90deg, #efd5ff 0%, #515ada 100%);
}

.cucumber-water {
    background: linear-gradient(90deg, #e3ffe7 0%, #d9e7ff 100%);
}

.lovely-pausam {
  background-image: linear-gradient( 109.6deg,  rgba(254,253,205,1) 11.2%, rgba(163,230,255,1) 91.1% );
  }

.dusty-clean {
  background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(226,240,254,1) 0%, rgba(255,247,228,1) 90% );

}  
  </style>
