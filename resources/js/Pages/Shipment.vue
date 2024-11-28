<template>
    <Header :data="{ client, admin }"></Header>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Document Shipment Portal</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Document Shipment Portal</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section class="section">
            <v-sheet>
            <v-card>
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
                    <strong>Passing Year:</strong> {{ format(parseISO(student.student_passing_year), 'dd MMMM yyyy')  }}
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
            <button @click="showCreateShipment" class="btn btn-primary mx-4 my-4">Create Shipment</button>
    <div class="mt-8 flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div
            class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
        >
            <div
                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative"
            >


                <table
                    class="min-w-full divide-y divide-gray-300"
                >
                    <thead class="bg-gray-50">
                        <tr>

                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
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
                            <th
                                scope="col"
                                class="py-3.5 pl-1 pr-1 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                            >
                                Action
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
                            <td
                            v-if="shipment.delivery_status != 'delivered'"
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                            <button @click="showUpdateShipment(shipment)"  class="btn btn-warning">Edit Shipment</button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
  </v-sheet>

<!-- ==================================== Create or Update Shipment Modal ================================== -->
 <v-dialog v-model="showShipmentModal">
        <!-- <v-card-title class="text-h6 text-center">Create Shipment for Document</v-card-title> -->
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <form @submit.prevent="createOrUpdateShipment">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                                <div>
                                    <h3
                                        class="text-lg leading-6 font-medium text-gray-900"
                                    >
                                        {{ modalTitle }} for Document
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Use this form to create a {{ modalTitle }}
                                    </p>
                                </div>
                                <v-combobox
                                    v-model="selectedDocuments"
                                    color="primary"
                                    :items="documents"
                                    item-value="id"
                                    item-title="document_name"
                                    label="Select documents..."
                                    chips
                                    multiple
                                ></v-combobox>
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label
                                            for="shipping_agent"
                                            class="block text-sm font-medium text-gray-700"
                                            >Shipping Agent</label
                                        >
                                        <input
                                        v-model="form.shipping_agent"
                                            type="text"
                                            id="shipping_agent"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        />
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label
                                            for="tracking_id"
                                            class="block text-sm font-medium text-gray-700"
                                            >Tracking ID</label
                                        >
                                        <input
                                        v-model="form.tracking_id"
                                            type="text"
                                            id="tracking_id"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        />
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label
                                            for="shipping_address"
                                            class="block text-sm font-medium text-gray-700"
                                            >Shipping Address</label
                                        >
                                        <input
                                        v-model="form.shipping_address"
                                            type="text"
                                            id="shipping_address"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        />
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label
                                            for="amount"
                                            class="block text-sm font-medium text-gray-700"
                                            >Amount</label
                                        >
                                        <input
                                        v-model="form.amount"
                                            type="text"
                                            id="amount"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        />
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label
                                            for="dispatched_at"
                                            class="block text-sm font-medium text-gray-700"
                                            >Dispatched At</label
                                        >
                                        <input
                                        v-model="form.dispatched_at"
                                            type="date"
                                            id="dispatched_at"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label
                                            for="delivery_status"
                                            class="block text-sm font-medium text-gray-700"
                                            >Delivery Status</label
                                        >
                                        <select
                                            v-model="form.delivery_status"
                                            id="delivery_status"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                            <option value="">Select Delivery Status</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                        </select>
                                    </div>
                                    <div v-if="form.delivery_status == 'delivered'" class="col-span-6 sm:col-span-3">
                                        <label
                                            for="delivered_at"
                                            class="block text-sm font-medium text-gray-700"
                                            >Delivered At</label
                                        >
                                        <input
                                        v-model="form.delivered_at"
                                            type="date"
                                            id="delivered_at"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        />
                                    </div>



                                </div>
                            </div>
                            <div
                                class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                            >
                                <a
                                    href="#"
                                    @click="showShipmentModal = false"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
                                >
                                    Cancel
                                </a>
                                <button
                                    type="submit"
                                    class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 </v-dialog>
        </section>
    </main>
    
</template>

<script setup>
import Header from "./Layouts/Header.vue";
import { usePage, useForm, router, Link} from '@inertiajs/vue3'
import axios from 'axios';
import { watch, ref, computed } from 'vue';
import { format, parseISO } from 'date-fns';
import { useToast } from "vue-toastification";


defineProps({
    student: {
        type: Object,
        required: true
    },
    shipments: {
        type: Object,
        required: true
    },
    client: {
        type: Object,
        required: true,
    },
    admin: {
        type: Object,
        required: true,
    },
});
const student = ref(usePage().props.student);
const shipments = ref(usePage().props.shipments);
console.log(shipments);

let selectedDocuments = ref([]);
const showShipmentModal = ref(false);
let documents = ref([]);
const toast = useToast();
let modalTitle = ref('');


const form = useForm({
    student_id: usePage().props.student.id,
    document_ids: computed(() => selectedDocuments.value.map(doc => doc.id)),
    shipment_id: "",
    tracking_id: "",
    shipping_agent: "",
    shipping_address: "",
    dispatched_at: "",
    amount: "",
    delivery_status: "",
    delivered_at: ""
});

const showCreateShipment = () => {
    modalTitle.value = "Create Shipment";
    selectedDocuments = ref([]);
    documents = ref(usePage().props.student.documents.filter(document => !document.shipment_id));
    form.student_id = usePage().props.student.id;
    form.document_ids = computed(() => selectedDocuments.value.map(doc => doc.id)),
    form.shipment_id = "";
    form.tracking_id = "";
    form.shipping_agent = "";
    form.shipping_address = "";
    form.dispatched_at = "";
    form.amount = "";
    form.delivery_status = "";
    form.delivered_at = "";
    console.log(form.student_id);
    showShipmentModal.value = true;
}
watch(selectedDocuments.value, (newVal)=>{
    console.log(newVal);
})

const showUpdateShipment = (shipment)=>{
    console.log("updateShipment has been called");
    modalTitle.value = "Update Shipment";
    documents.value = shipment.documents;
    form.document_ids = computed(() => documents.value.map(doc => doc.id));
    selectedDocuments = form.document_ids;
    form.shipment_id = shipment.id;
    form.tracking_id = shipment.tracking_id;
    form.shipping_agent = shipment.shipping_agent;
    form.shipping_address = shipment.shipping_address;
    form.dispatched_at = shipment.dispatched_at;
    form.amount = shipment.amount;
    form.delivery_status = shipment.delivery_status;
    form.delivered_at = shipment.delivered_at;
    showShipmentModal.value = true;
}

const createOrUpdateShipment = () => {
    // Convert form to plain object
    const formData = {
        student_id: form.student_id,
        document_ids: form.document_ids,
        shipment_id: form.shipment_id,
        tracking_id: form.tracking_id,
        shipping_agent: form.shipping_agent,
        shipping_address: form.shipping_address,
        dispatched_at: form.dispatched_at,
        amount: form.amount,
        delivery_status: form.delivery_status,
        delivered_at: form.delivery_status === 'delivered' ? form.delivered_at : null
    };

    axios.post('/shipments/create', formData)
        .then((response) => {
            form.value = {};
            showShipmentModal.value = false;

            // Update the page state
            student.value = response.data.student;
            shipments.value = response.data.shipments;
            
            // Update Inertia page props manually
            usePage().props.student = response.data.student;
            usePage().props.shipments = response.data.shipments;

            toast.success("Shipment created successfully!");
        })
        .catch((error) => {
            console.error('Error:', error.response?.data?.message || 'Something went wrong');
            toast.error(error.response?.data?.message || "Failed to create shipment!");
            
            // Handle validation errors if any
            if (error.response?.data?.errors) {
                Object.keys(error.response.data.errors).forEach(key => {
                    const message = error.response.data.errors[key][0];
                    toast.error(`${key}: ${message}`);
                });
            }
        });
};

watch(form, (newVal)=>{
    console.log(newVal);
})
</script>

<style scoped>
.custom-checkbox {
  appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid #d1d5db; /* light gray border */
  border-radius: 4px; /* slightly rounded corners */
  background-color: white; /* default background */
  outline: none;
  cursor: pointer;
  transition: background-color 0.2s ease, border-color 0.2s ease;
  position: relative;
}

/* Checkbox hover effect */
.custom-checkbox:hover {
  border-color: #4b5563; /* darker gray on hover */
}

/* Checkbox checked state */
.custom-checkbox:checked {
  background-color: #2563eb; /* blue background when checked */
  border-color: #2563eb; /* blue border when checked */
}

/* Focus state for accessibility */
.custom-checkbox:focus {
  box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.5); /* blue outline */
}

::v-deep .v-text-field .v-field--no-label input
{
  opacity: 0 !important;
}

</style>
