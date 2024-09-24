<template>
    <!-- <Header :data="{ client, admin }"></Header> -->
    
        <!-- End Page Title -->
        <section class="section">
            <v-sheet class="elevation-4 rounded">
                <v-form @submit.prevent="getShipmentTracking()">
                <v-row class="mx-12  my-2">
                    
                        <v-col cols="6" md="4">
                            <v-text-field
                            v-model="name"
                            label="Enter your name"
                            variant="outlined"
                            hide-details
                            single-line
                            :rules="[v => !!v || 'Name is required']"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" md="5">
                            <v-text-field
                            v-model="student_rollNo"
                            label="Search roll number"
                            prepend-inner-icon="mdi-magnify"
                            variant="outlined"
                            hide-details
                            single-line
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="3" class="d-flex align-self-center">
                        <v-btn size="large" class="ooey-gooey text-white" type="submit">Search</v-btn>
                    </v-col>
                </v-row>
            </v-form>
            <v-card v-if="student" class="mx-12 elevation-4">
                <v-card-title class="text-h6 text-center">{{ student.student_name }}</v-card-title>
                <v-card-subtitle class="text-center">Roll No: {{ student.student_roll_no }}</v-card-subtitle>

                <v-divider></v-divider>

                <v-card-text>
                <v-row>
                    <v-col cols="3" class="py-1">
                    <strong>Email:</strong> {{ student.email }}
                    </v-col>
                    <v-col cols="3" class="py-1">
                    <strong>City:</strong> {{ student.student_city }}
                    </v-col>
                    <v-col cols="3" class="py-1">
                    <strong>Address:</strong> {{ student.student_address }}
                    </v-col>
                    <v-col cols="3" class="py-1">
                    <strong>Pincode:</strong> {{ student.student_pincode }}
                    </v-col>
                    <v-col cols="3" class="py-1">
                    <strong>Exam Cycle:</strong> {{ student.exam_cycle }}
                    </v-col>
                    <v-col cols="3" class="py-1">
                    <strong>Passing Year:</strong> {{ student.student_passing_year }}
                    </v-col>
                    <v-col cols="3" class="py-1">
                    <strong>Exam Status:</strong> {{ student.student_exam_status }}
                    </v-col>
                    <v-col cols="3" class="py-1">
                    <strong>Created By:</strong> {{ student.created_by }}
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="4" class="py-1"><strong style="color:brown">Documents Pending</strong>
                        <span v-for="document in student.documents">
                        <li 
                        v-if="!document?.shipment_id"
                        style="list-style-type: none;">
                            <v-icon size="medium" color="red-darken-4" icon="mdi-knob" class="mx-1"></v-icon>{{ document.document_name }}</li>
                    </span>
                    </v-col>
                    <v-col cols="4" class="py-1"><strong style="color:darkorange">Documents Shipped</strong>
                    <span v-for="document in student.documents">
                        <li 
                        v-if="document?.shipment_id && document.shipment.delivery_status == 'shipped'"
                        style="list-style-type: none;">
                            <v-icon size="medium" color="warning" icon="mdi-truck" class="mx-1"></v-icon>{{ document.document_name }}</li>
                    </span>
                    </v-col>
                    <v-col cols="4" class="py-1"><strong style="color:darkgreen">Documents Delivered</strong>
                        <span v-for="document in student.documents">
                        <li 
                        v-if="document?.shipment_id && document.shipment.delivery_status == 'delivered'"
                        style="list-style-type: none;">
                            <v-icon size="medium" color="green-darken-2" icon="mdi-check-decagram" class="mx-1"></v-icon>{{ document.document_name }}</li>
                    </span>
                    </v-col>
                </v-row>
                </v-card-text>
            </v-card>
    <div class="mx-12 my-8 flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div
            class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
        >
            <div
                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative"
            >


                <table v-if="shipments.length > 0"
                    class="min-w-full divide-y divide-gray-300"
                >
                    <thead class="bg-gray-50">
                        <tr>

                            <th
                                scope="col"
                                class="py-3.5 pl-4 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Documents
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Tracking ID
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Shipping Agent
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Shipping Address
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Dispatched At
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Amount
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Delivery Status
                            </th>
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Delivered At
                            </th>
                        </tr>
                    </thead>
                    <tbody v-for="shipment in shipments" :key="student.id"
                        class="divide-y divide-gray-200 bg-white"
                    >
                        <tr>
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                            <li style="list-style-type: none;" v-for="document in shipment.documents" :key="document.id">
                                <v-icon size="medium" color="green-darken-2" icon="mdi-check-circle" class="mx-1"></v-icon>{{ document.document_name }}
                            </li>
                            </td>
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                            {{ shipment.tracking_id }}
                            </td>

                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                                {{ shipment.shipping_agent || 'N/A' }}
                            </td>
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                                {{ shipment.shipping_address || 'N/A' }}
                            </td>
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                                {{ shipment.dispatched_at || 'N/A' }}
                            </td>
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                                {{ shipment.amount || 'N/A' }}
                            </td>
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                                {{ shipment.delivery_status || 'N/A' }}
                            </td>
                            <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                                {{ shipment.delivered_at || 'N/A' }}
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
  </v-sheet>
        </section>
</template>

<script setup>
import Header from "../Layouts/Header.vue";
import { ref, watch, onBeforeMount } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import axios from "axios";
defineProps({
    client: {
        type: Object,
        required: true,
    },
    admin: {
        type: Object,
        required: true,
    },
    student: {
        type: Object,
        required: true
    },
    shipments: {
        type: Object,
        required: true
    },
});
let client_code = usePage().props.client.code;
const student = ref(usePage().props.student);
const shipments = ref(usePage().props.shipments);
let student_rollNo = ref("");
let name = ref("");

watch(name, (newVal) => {
    console.log(name.value);
})

const getShipmentTracking = () => {
    if(name.value.length === 0) {
        alert("Please enter student name");
        return;
    }

    router.visit(`/shipment/track/${client_code}/${student_rollNo.value}`);
}
</script>

<style scoped>

.ooey-gooey {
    background: linear-gradient(90deg, #0700b8 0%, #00ff88 100%);
}
</style>