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
                <v-row class="" align="center" justify="space-around">
                    <!-- Documents Generated Card -->

                        <v-col cols="12" md="6" v-show="!loading">
                            <v-card title="Documents Generated" class="mx-auto card-shadow dashboard-card mb-5"
                                subtitle="Total no. of documents generated till now">
                                <template v-slot:prepend>
                                    <v-icon style="color: #4154f1; background: #f6f6fe;" icon="mdi-file-sign"></v-icon>

                                </template>
                                <template v-slot:append>
                                    <span style="font-weight: bold; font-size: 48px; color: #012970;">{{ generatedDocs }}</span>
                                </template>
                                <v-row align="center" justify="center" dense>
                                    <v-col cols="4" align="center" justify="center" dense>
                                        <v-card-item>
                                            <v-card-title class="dashboard-sub-count"> {{ summaryStats.pendings }}
                                            </v-card-title>
                                            <v-card-subtitle class="dashboard-sub-details">
                                                document <br />pending
                                            </v-card-subtitle>
                                        </v-card-item>
                                    </v-col>
                                    <v-col cols="4" align="center" justify="center" dense>
                                        <v-card-item>
                                            <v-card-title class="dashboard-sub-count"> {{ summaryStats.shipped }}
                                            </v-card-title>
                                            <v-card-subtitle class="dashboard-sub-details">
                                                document <br />shipped
                                            </v-card-subtitle>
                                        </v-card-item>
                                    </v-col>
                                    <v-col cols="4" align="center" justify="center" dense>
                                        <v-card-item>
                                            <v-card-title class="dashboard-sub-count"> {{ summaryStats.delivered }}
                                            </v-card-title>
                                            <v-card-subtitle class="dashboard-sub-details">
                                                document <br />delivered
                                            </v-card-subtitle>
                                        </v-card-item>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-card title="Total" class="mx-auto card-shadow dashboard-card mb-5" subtitle="Total no. of students enrolled till now">
                                <template v-slot:prepend>
                                    <v-icon style="color: #2eca6a; background: #e0f8e9;" icon="mdi-cards-variant"></v-icon>
                                </template>
                                <template v-slot:append>
                                    <span style="font-weight: bold; font-size: 48px; color: #012970;">{{ students }}</span>
                                </template>
                                <v-row align="center" justify="center" dense>
                                    <v-col cols="4" align="center" justify="center" dense>
                                        <v-card-item>
                                            <v-card-title class="dashboard-sub-count"> {{ summaryStats.passed }}
                                            </v-card-title>
                                            <v-card-subtitle class="dashboard-sub-details">
                                                student <br />passed
                                            </v-card-subtitle>
                                        </v-card-item>
                                    </v-col>
                                    <v-col cols="4" align="center" justify="center" dense>
                                        <v-card-item>
                                            <v-card-title class="dashboard-sub-count"> {{ summaryStats.failed }}
                                            </v-card-title>
                                            <v-card-subtitle class="dashboard-sub-details">
                                                student <br />failed
                                            </v-card-subtitle>
                                        </v-card-item>
                                    </v-col>
                                    <v-col cols="4" align="center" justify="center" dense>
                                        <v-card-item>
                                            <v-card-title class="dashboard-sub-count"> {{ summaryStats.failed }}
                                            </v-card-title>
                                            <v-card-subtitle class="dashboard-sub-details">
                                                student <br />pendings
                                            </v-card-subtitle>
                                        </v-card-item>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-col>
                </v-row>
                <v-divider class="my-4"></v-divider>

                <!-- Charts and Filters Section -->
                <v-sheet class="">

                    <!-- ================================ skeleton loader ends here  ========================================= -->
                    <v-row class="mt-4 mb-4">
                        <!-- Line Chart for Exam Cycle Timeline -->
                        <v-col cols="12" md="7">
                            <v-skeleton-loader v-if="loading" elevation="8" height="150"
                                type="table-heading, list-item-two-line, image, table-tfoot"></v-skeleton-loader>
                            <v-sheet v-show="!loading" class="v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow dashboard-card mb-5">
                                <!-- <LineChart :data="examCycleTimeline"></LineChart> -->
                                <LineChart></LineChart>
                            </v-sheet>
                        </v-col>

                        <!-- Calendar Image Card -->
                        <v-col cols="12" md="5">
                            <v-skeleton-loader v-if="loading" elevation="8"
                                type="table-heading, list-item-two-line, image, table-tfoot"></v-skeleton-loader>
                            <v-card v-show="!loading" class="v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow mb-5">
                                <v-table fixed-header class="glass-table" :aria-describedby="'line-chart-table'">
                                    <thead>
                                        <tr>
                                            <th class="text-left font-weight-bold text-primary">Exam Cycle</th>
                                            <th class="text-left font-weight-bold text-primary">
                                            <v-icon size="large" icon="mdi-alert-octagon-outline" class="mx-1" style="color: rgb(241 68 65);background: rgb(255 231 231);width: 40px;height: 40px;border-radius: 50px;"></v-icon>
                                            Pending
                                            </th>
                                            <th class="text-left font-weight-bold text-primary">
                                            <v-icon size="large" icon="mdi-rocket" class="mx-1" style="color: rgb(241 146 65);background: rgb(255 239 231);width: 40px;height: 40px;border-radius: 50px;"></v-icon>
                                            Shipped</th>
                                            <th class="text-left font-weight-bold text-primary">
                                            <v-icon size="large" icon="mdi-check-decagram-outline" class="mx-1" style="color: rgb(20 202 109);background: rgb(231 255 235);width: 40px;height: 40px;border-radius: 50px;"></v-icon>
                                            Delivered
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(category, index) in examCycleTimeline.categories.slice(0,5)" :key="index">
                                            <td class="font-weight-bold text-green-darken-2">{{ category }}</td>
                                            <td class="text-green-darken-2 text-center">{{ examCycleTimeline.series[0].data[index]
                                                }}</td>
                                            <td class="text-green-darken-2 text-center">{{ examCycleTimeline.series[1].data[index]
                                                }}</td>
                                            <td class="text-green-darken-2 text-center">{{ examCycleTimeline.series[2].data[index]
                                                }}</td>
                                        </tr>
                                    </tbody>
                                </v-table>
                            </v-card>
                        </v-col>

                    </v-row>

                    <v-divider class="my-4"></v-divider>

                    <v-row class="mt-5 mb-4">
                        <!-- Pie Chart for Document Summary -->
                        <v-col cols="12" md="4">
                            <v-skeleton-loader v-if="loading" elevation="8"
                                type="table-heading, list-item-two-line, image, table-tfoot"
                                height="500"></v-skeleton-loader>
                            <v-sheet v-show="!loading" class="v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow mb-5">
                                <DocumentPieChart :summaryData="summaryStats"></DocumentPieChart>
                            </v-sheet>
                        </v-col>

                        <!-- Bar Chart with Exam Cycle Filter -->
                        <v-col cols="12" md="8">
                            <v-sheet class="v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow mb-5">
                                <v-skeleton-loader v-if="loading" elevation="8"
                                    type="table-heading, list-item-two-line, image, table-tfoot"
                                    height="400"></v-skeleton-loader>
                                <v-row align="center" justify="space-between">

                                    <v-col v-show="!loading" cols="12" md="4">
                                        <v-select label="Select Exam Cycle" v-model="selectedExamCycle"
                                            :items="filterExamcycle" variant="outlined" color="primary"
                                            prepend-icon="mdi-calendar" class="w-100"></v-select>
                                    </v-col>
                                    <v-col v-show="!loading" cols="12" md="8">
                                        <ExamCycleBarChart :examCycleData="examCycleStats"></ExamCycleBarChart>
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
import { useToast } from "vue-toastification";
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
const toast = useToast();

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
    console.log("Selected Exam cycle is: ", newVal);
    fetchExamCycle(newVal);

})

// fetchExamCycle("Jun-2024");


const fetchSummary = async () => {
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
        toast.error("Error fetching data");
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
            toast.error("Error fetching data");
        });
}

const fetchExamCycleTimeline = async () => {
    // Fetch exam cycle timeline data here
    try {
        const response = await fetch('/dashboard/exam_cycle/timeline');
        const data = await response.json();
        examCycleTimeline.categories = data.categories;
        examCycleTimeline.series = data.series;
        lineChartTable.value = data.table; // Populate the table with data for line chart
        console.log("Exam Cycle Timeline Data:", data);
    }
    catch (error) {
        console.error('Error fetching exam cycle timeline data:', error);
        toast.error("Error fetching exam cycle timeline data");
    }
}

const populateExamCycle = async () => {
    // Populate exam cycle options here
    try {
        const response = await fetch('/dashboard/populateExamCycle');
        const data = await response.json();
        filterExamcycle.value = data.exam_cycles;
        console.log("Exam Cycle Options:", filterExamcycle.value);
    }
    catch (error) {
        console.error('Error fetching exam cycle options:', error);
        toast.error("Error fetching exam cycle options:")
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
    background-color: #f4f6f9;
    /* Light background for contrast */
}

.v-card {
    border-radius: 12px;
    /* Rounded corners for cards */
}

.v-sheet {
    border-radius: 12px;
    /* Rounded corners for sheets */
}

.text-h6 {
    font-weight: bold;
    /* Make text bold for emphasis */
}

.elevation-1,
.elevation-3 {
    transition: box-shadow 0.3s ease;
    /* Smooth hover effect */
}

.elevation-1:hover,
.elevation-3:hover {
    box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
    /* Hover shadow effect */
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
    background-image: linear-gradient(109.6deg, rgba(254, 253, 205, 1) 11.2%, rgba(163, 230, 255, 1) 91.1%);
}

.dusty-clean {
    background-image: radial-gradient(circle farthest-corner at 10% 20%, rgba(226, 240, 254, 1) 0%, rgba(255, 247, 228, 1) 90%);

}

::v-deep .v-sheet {
    /* box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1)!important; */
    background: transparent;
}
.card-shadow{
    box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
    padding: 15px;
    background: #fff;
}
.dashboard-card i {
    font-size: 32px;
    line-height: 0;
    width: 64px;
    height: 64px;
    flex-shrink: 0;
    flex-grow: 0;
    border-radius: 50%
}
::v-deep .dashboard-card .v-card-item .v-card-title   {
    color: #012970 !important;
    font-weight: 600;
    font-size: 24px;
}
::v-deep .v-card-item .v-card-subtitle {
    padding: 0 0 0.25rem;
    text-transform: capitalize;
    color: #314c81;
    font-weight: 500;
}

</style>
