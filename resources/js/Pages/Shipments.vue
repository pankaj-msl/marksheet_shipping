<template>
    <div ></div>
    <Header :data="{ client, admin }"></Header>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Students Document Shipments</h1>
            <!-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Marksheet Uploading</li>
                </ol>
            </nav> -->
        </div>
        <!-- End Page Title -->
        <section class="section">
            Shipment Tracking
            <v-row class="d-flex justify-space-between">
                <v-col cols="12" md="6">
                        <v-text-field
                        v-model="search"
                        label="Search by name, roll number or email ..."
                        prepend-inner-icon="mdi-magnify"
                        variant="outlined"
                        hide-details
                        single-line
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="3" offset="3" class="d-flex align-self-center">
                    <v-btn class="ooey-gooey text-white" @click="downloadReport()">Download Shipment Report</v-btn>
                </v-col>
            </v-row>
            <div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div
            class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
        >
            <div
                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative mx-1"
            >


                <table
                    class="min-w-full divide-y divide-gray-300"
                >
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                ID
                            </th> -->
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                            >
                                Roll No
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                            >
                                Name
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                            >
                                Email
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                            >
                                Pendings
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                            >
                                Shipped
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                            >
                                Delivered
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                            >
                                Shipment Tracking
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                            >
                                Report
                            </th>
                        </tr>
                    </thead>
                    <!-- Handle students data -->
                    <tbody v-if="loading || students.data.length === 0"
                        class="divide-y divide-gray-200 bg-white"
                    >
                        <!-- Handle students data if it is empty -->
                        <tr v-if="loading">
                            <td
                                class="text-center px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                :colspan="7"
                            >
                                Loading students data please wait ...
                            </td>
                        </tr>
                    <!-- Handle students data if it is empty -->
                        <tr v-if="students.data.length === 0">
                            <td
                                class="text-center px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                :colspan="7"
                            >
                                Oops no students data available
                            </td>
                        </tr>
                    </tbody>
                    <!-- Display students data -->
                    <tbody v-for="student in students.data"
                        class="divide-y divide-gray-200 bg-white"
                    >
                        <tr  v-if="student.documents.length > 0">
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 text-secondary sm:pl-6"
                            >
                                 {{ student.student_roll_no }}
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-primary"
                            >
                            <v-icon icon="mdi-account"></v-icon>
                               {{ student.student_name }} 
                            </td>
                            <td
                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-warning"
                            >
                            <v-icon :icon="student.email ? 'mdi-email' : ''"></v-icon>
                            {{ student.email }} 
                        </td>

                        
                        
                        <td 
                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-primary"
                        >
                        <span v-for="document in student.documents">
                            <li v-if="!document?.shipment_id" style="list-style-type: none;"><v-icon size="medium" color="red-darken-4" icon="mdi-knob" class="mx-1"></v-icon>{{ document.document_name }}</li>
                        </span>
                        </td>
                        <td 
                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-primary"
                        >
                        <span v-for="document in student.documents">
                            <li 
                            v-if="document?.shipment_id && document.shipment.delivery_status == 'shipped'"
                            style="list-style-type: none;">
                                <v-icon size="medium" color="warning" icon="mdi-truck" class="mx-1"></v-icon>{{ document.document_name }}</li>
                        </span>
                        
                            
                        </td>
                        <td 
                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-primary"
                        >
                        <span v-for="document in student.documents">
                            <li 
                            v-if="document?.shipment_id && document.shipment.delivery_status == 'delivered'"
                            style="list-style-type: none;">
                                <v-icon size="medium" color="green-darken-2" icon="mdi-check-decagram" class="mx-1"></v-icon>{{ document.document_name }}</li>
                        </span>
                            
                        </td>
                        <td
                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                            >
                            
                                <button class="text-success" @click="postTrackingId(student.id)">
                                    Track Shipment
                                </button>
                                <v-icon icon="mdi-truck" color="primary" class="mx-1"></v-icon>
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                            >
                            
                                <button class="text-primary" @click="generateReport(student.id)">
                                   Generate Report
                                </button>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- ======================================== Pagination =============================================== -->
<div v-if="students.current_page" class="max-w-7xl mx-auto py-6">
        <div class="max-w-none mx-auto">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div
                    class="bg-white px-4 py-3 flex items-center justify-between"
                >
                    <div class="flex-1 flex justify-between sm:hidden" />
                    <div
                        class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="text-sm text-gray-700 text-primary">
                                Showing
                                <!-- space -->
                                <span class="font-medium">{{ students.from }}</span>
                                <!-- space -->
                                to
                                <!-- space -->
                                <span class="font-medium">{{ students.to }}</span>
                                <!-- space -->
                                of
                                <!-- space -->
                                <span class="font-medium"> {{ students.total }} </span>
                                <!-- space -->
                                results
                            </p>
                        </div>
                        <div>
                            <button
                            @click.prevent="updatePageNumber(link)"

                            v-for="(link,index) in students.links"
                                :key="index"
                                    :disabled="link.active || !link.url"
                                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                    :class="{
                                        'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                                        'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active,
                                    }"

                                >
                                    <span v-html="link.label" class="text-primary"></span>
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- ======================================== Pagination Ends Here ===================================== -->
        </section>
    </main>
</template>

<script setup>
import Header from "./Layouts/Header.vue";
import { ref, watch, onBeforeMount } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

defineProps({
    client: {
        type: Object,
        required: true,
    },
    admin: {
        type: Object,
        required: true,
    }
});

let search = ref("");
let students = ref({});
let debounceTimeout = null;
let pageNumber = ref(1);
const toast = useToast();
const loading = ref(false);

// Watch the search query and debounce the API call
watch(search, (newVal) => {
  console.log('Search query changed:', newVal);
  pageNumber.value = 1;

  if (debounceTimeout) clearTimeout(debounceTimeout);

  debounceTimeout = setTimeout(() => {
    getFilteredData();
  }, 500);
});

//pagination
const updatePageNumber = (link) => {
    pageNumber.value = link.url.split('=')[1];
    getFilteredData();
};


//main function
const getFilteredData = () => {
    loading.value = true;
    axios.get('/shipments/view', {
        params: {
            query: search.value,
            page: pageNumber.value,
            // pass_status: filterByPassStatus.value,

        },
    })
    .then((response) => {
        console.log(response);
        loading.value = false;
         students.value = response.data.students;
     })
     .catch((error) => {
         console.error(error.message);
         loading.value = false;
         toast.error(error.message);
     });
}

const postTrackingId = (studentId) => {
    router.visit(`/shipment/student/${studentId}`);
}

const generateReport = (studentId) => {
    axios.get(`/shipments/generate-report/${studentId}`, {
        responseType: 'blob', // Important for handling binary data
    })
    .then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `shipments_student_${studentId}.xlsx`);
        document.body.appendChild(link);
        link.click();

        // Clean up and remove the link
        link.parentNode.removeChild(link);
    })
    .catch((error) => {
        console.error(error.message);
        toast.error(error.message);
    });
}

const downloadReport = () => {
    axios.get('/shipments/download', {
        responseType: 'blob', // Important for handling binary data
    })
    .then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'all_shipments.xlsx');
        document.body.appendChild(link);
        link.click();

        // Clean up and remove the link
        link.parentNode.removeChild(link);
    })
    .catch((error) => {
        console.error(error.message);
        toast.error(error.message);
    });
}


onBeforeMount(() => {
    getFilteredData();
});
</script>

<style scoped>
.ooey-gooey {
    background: linear-gradient(90deg, #0700b8 0%, #00ff88 100%);
}
</style>