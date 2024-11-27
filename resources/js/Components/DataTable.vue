<template>
    <v-row class="justify-content-center">
        <v-col cols="12" md="12" class="text-center"
            ><img
                src="../../../public/assets/img/student-search.gif"
                style="margin: auto; display: block; margin-bottom: 20px"
            />
            <p class="mb-0">Search student by Name /Email ID /Roll No</p>
        </v-col>

        <v-col cols="12" md="6" class="search-box">
            <v-text-field
                v-model="search"
                label="Search by Name, Roll number or Email ..."
                prepend-inner-icon="mdi-magnify"
                variant="outlined"
                hide-details
                single-line
            ></v-text-field>
        </v-col>
        <v-col cols="12" md="12" class="px-5"><hr /></v-col>
        <v-col cols="12" md="9">
            <div class="flex flex-col">
                <div class="">
                    <div class="">
                        <div class="" style="overflow-x: auto;">
                            <table class="min-w-full divide-y marksheet-table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                                        >
                                            Select Student
                                        </th>
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
                                            <div
                                                class="flex items-center space-x-2"
                                            >
                                                <!-- <span>Pass Status</span> -->
                                                <!-- Filter Dropdown Inside the Header -->
                                                <select
                                                    v-model="filterByPassStatus"
                                                    class="border border-white text-sm rounded focus:outline-none"
                                                >
                                                    <option value="">
                                                        Pass Status
                                                    </option>
                                                    <option value="passed">
                                                        Passed
                                                    </option>
                                                    <option value="failed">
                                                        Failed
                                                    </option>
                                                    <option value="pending">
                                                        Pending
                                                    </option>
                                                </select>
                                            </div>
                                        </th>
                                        <th
                                            scope="col"
                                            class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                                        >
                                            <select
                                                v-model="
                                                    filterByGeneratedStatus
                                                "
                                                class="border border-white text-sm rounded"
                                            >
                                                <option value="">
                                                    Generated Status
                                                </option>
                                                <option value="generated">
                                                    Generated
                                                </option>
                                                <option value="not_generated">
                                                    Not Generated
                                                </option>
                                            </select>
                                        </th>
                                        <th
                                            scope="col"
                                            class="py-3.5 pl-1 pr-1 text-left text-sm text-primary font-semibold text-gray-900 sm:pl-6"
                                        >
                                            Shipment Tracking
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-gray-200 bg-white"
                                >
                                    <tr
                                        v-for="student in students.data"
                                        :key="student.id"
                                    >
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6"
                                        >
                                            <input
                                                type="checkbox"
                                                :value="student.id"
                                                v-model="selectedStudents"
                                                class="custom-checkbox"
                                            />
                                        </td>
                                        <!-- <td
                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                            >
                                {{ student.id }}
                            </td> -->
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
                                            <v-icon
                                                :icon="
                                                    student.email
                                                        ? 'mdi-email'
                                                        : ''
                                                "
                                            ></v-icon>
                                            {{ student.email }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                        >
                                            <button
                                                :class="{
                                                    'bg-green-500 text-white px-4 py-2 rounded text-capitalize':
                                                        student.student_exam_status ===
                                                        'passed',
                                                    'bg-red-500 text-white px-4 py-2 rounded text-capitalize':
                                                        student.student_exam_status ===
                                                        'failed',
                                                    'bg-yellow-500 text-white px-4 py-2 rounded text-capitalize':
                                                        student.student_exam_status ===
                                                        'pending',
                                                }"
                                                disabled
                                            >
                                                <v-icon
                                                    :icon="
                                                        student.student_exam_status ===
                                                        'passed'
                                                            ? 'mdi-account-check-outline'
                                                            : 'mdi-account-cancel-outline'
                                                    "
                                                ></v-icon>
                                                {{
                                                    student.student_exam_status
                                                }}
                                            </button>
                                        </td>
                                        <td>
                                            <v-tooltip
                                                no-click-animation
                                                variant="outlined"
                                                prominent
                                            >
                                                <template
                                                    v-slot:activator="{ props }"
                                                >
                                                    <button
                                                        v-bind="props"
                                                        @click="
                                                            getStudentDocumentDetails(
                                                                student
                                                            )
                                                        "
                                                        :disabled="
                                                            student.documents
                                                                .length < 1
                                                        "
                                                        :class="{
                                                            'bg-green-500 text-white px-4 py-2 rounded':
                                                                student
                                                                    .documents
                                                                    .length &&
                                                                student
                                                                    .documents[0]
                                                                    .is_document_generated ===
                                                                    'yes',
                                                            'bg-red-500 text-white px-4 py-2 rounded':
                                                                student
                                                                    .documents
                                                                    .length < 1,
                                                        }"
                                                    >
                                                        <v-icon
                                                            :icon="
                                                                student
                                                                    .documents
                                                                    .length &&
                                                                student
                                                                    .documents[0]
                                                                    .is_document_generated ===
                                                                    'yes'
                                                                    ? 'mdi-note-check'
                                                                    : 'mdi-note-remove'
                                                            "
                                                        ></v-icon>
                                                        {{
                                                            student.documents
                                                                .length &&
                                                            student.documents[0]
                                                                .is_document_generated ===
                                                                "yes"
                                                                ? "Generated"
                                                                : "Not Generated"
                                                        }}
                                                    </button>
                                                </template>

                                                <div>
                                                    <div
                                                        v-if="
                                                            student.documents
                                                                .length > 0
                                                        "
                                                    >
                                                        <div
                                                            v-for="document in student.documents"
                                                        >
                                                            <li
                                                                style="
                                                                    list-style-type: none;
                                                                "
                                                            >
                                                                {{
                                                                    document.document_name
                                                                }}
                                                            </li>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <p class="text-center">
                                                            No documents
                                                            generated yet.
                                                        </p>
                                                    </div>
                                                </div>
                                            </v-tooltip>
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                        >
                                            <button
                                                class="text-success"
                                                @click="
                                                    postTrackingId(student.id)
                                                "
                                            >
                                                Track Shipment
                                            </button>
                                            <v-icon
                                                icon="mdi-truck"
                                                color="primary"
                                                class="mx-1"
                                            ></v-icon>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================================== Pagination =============================================== -->
            <div v-if="students.current_page" class="">
                <div class="max-w-none mx-auto">
                    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                        <div
                            class="bg-white px-4 py-3 flex items-center justify-between"
                        >
                            <div
                                class="flex-1 flex justify-between sm:hidden"
                            />
                            <div
                                class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                            >
                                <div>
                                    <p
                                        class="text-sm text-gray-700 text-primary"
                                    >
                                        Showing
                                        <!-- space -->
                                        <span class="font-medium">{{
                                            students.from
                                        }}</span>
                                        <!-- space -->
                                        to
                                        <!-- space -->
                                        <span class="font-medium">{{
                                            students.to
                                        }}</span>
                                        <!-- space -->
                                        of
                                        <!-- space -->
                                        <span class="font-medium">
                                            {{ students.total }}
                                        </span>
                                        <!-- space -->
                                        results
                                    </p>
                                </div>
                                <div>
                                    <button
                                        @click.prevent="updatePageNumber(link)"
                                        v-for="(link, index) in students.links"
                                        :key="index"
                                        :disabled="link.active || !link.url"
                                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                        :class="{
                                            'z-10 bg-indigo-50 border-indigo-500 text-indigo-600':
                                                link.active,
                                            'bg-white border-gray-300 text-gray-500 hover:bg-gray-50':
                                                !link.active,
                                        }"
                                    >
                                        <span
                                            v-html="link.label"
                                            class="text-primary"
                                        ></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======================================== Pagination Ends Here ===================================== -->
        </v-col>
        <v-col cols="12" md="3">
            <v-row class="justify-content-center align-items-center">
                <v-col cols="12" md="12" class="py-2">
                    <p class="custom-title">Select Students and Generate Documents</p>

                    <div class="form-floating">
                        <select
                            @change="fetchDocs"
                            v-model="docType"
                            class="select2 form-control"
                        >
                            <option value="documents">Final Documents</option>
                            <option value="semesters">
                                Semester Marksheet
                            </option>
                        </select>
                        <label for="floatingSelect">Update Document Type</label>
                    </div>
                </v-col>
                <v-col v-if="docType" cols="12" md="12" class="py-2">
                    <p class="">Select  Documents to be Generated</p>
                    <v-combobox
                        v-model="selectedDocuments"
                        color="primary"
                        :items="documents"
                        chips
                        variant="outlined"
                        multiple
                    ></v-combobox>
                </v-col>
                <v-col v-if="selectedDocuments.length > 0" cols="12" md="12" class="d-flex justify-content-center align-items-center py-2 px-2">
                    <v-btn
                        @click="generateDocument()"
                        class="btn btn-primary text-subtitle-1 text-white"
                        ><v-icon icon="mdi-check-circle"></v-icon> Generate
                        Document</v-btn
                    >
                </v-col>

                <div data-v-22f91e27="" class="v-col-md-12 v-col-12"><hr data-v-22f91e27=""></div>

                <v-col cols="12" md="12">
                    <p class="custom-title">Selects Students and Update Exam Status</p>
                    <div class="form-floating mb-3">
                        <select
                            @change="updatePassStatus"
                            v-model="passStatus"
                            class="select2 form-control"
                        >
                            <option value="passed">Passed</option>
                            <option value="failed">Failed</option>
                            <option value="pending">Pending</option>
                        </select>
                        <label for="floatingSelect">Update Exam Status</label>
                    </div>
                </v-col>
            </v-row>
        </v-col>

        
    </v-row>

    <!-- ============================ Document Generation Modal ============================= -->

    <!-- Dialog to show document details -->
    <v-dialog v-model="dialogVisible" max-width="600px">
        <v-card class="mx-auto my-24" max-width="780" outlined>
            <v-card-title class="text-h6 text-center text-primary">
                <v-icon icon="mdi-account"></v-icon>
                {{ modalDocDetails.student_name }}</v-card-title
            >
            <v-card-subtitle class="text-center text-primary">
                <v-icon icon="mdi-file-sign"></v-icon> Roll No:
                {{ modalDocDetails.student_roll_no }}</v-card-subtitle
            >

            <v-divider></v-divider>

            <v-card-text>
                <v-row>
                    <v-col cols="6" class="py-1 text-primary">
                        <strong>
                            <v-icon icon="mdi-email"></v-icon> Email:</strong
                        >
                        {{ modalDocDetails.email }}
                    </v-col>
                    <v-col cols="6" class="py-1 text-primary">
                        <strong>
                            <v-icon icon="mdi-city"></v-icon> City:</strong
                        >
                        {{ modalDocDetails.student_city }}
                    </v-col>
                    <v-col cols="6" class="py-1 text-primary">
                        <strong>
                            <v-icon icon="mdi-map-marker"></v-icon>
                            Address:</strong
                        >
                        {{ modalDocDetails.student_address }}
                    </v-col>
                    <v-col cols="6" class="py-1 text-primary">
                        <strong>
                            <v-icon icon="mdi-pin"></v-icon> Pincode:</strong
                        >
                        {{ modalDocDetails.student_pincode }}
                    </v-col>
                    <v-col cols="6" class="py-1 text-primary">
                        <strong>
                            <v-icon icon="mdi-restore"></v-icon> Exam
                            Cycle:</strong
                        >
                        {{ modalDocDetails.exam_cycle }}
                    </v-col>
                    <v-col cols="6" class="py-1 text-primary">
                        <strong>
                            <v-icon icon="mdi-clock-check"></v-icon> Passing
                            Year:</strong
                        >
                        {{ modalDocDetails.student_passing_year }}
                    </v-col>
                    <v-col cols="6" class="py-1 text-primary">
                        <strong>
                            <v-icon icon="mdi-creation"></v-icon> Exam
                            Status:</strong
                        >
                        {{ modalDocDetails.student_exam_status }}
                    </v-col>
                    <v-col cols="6" class="py-1 text-primary">
                        <strong>
                            <v-icon icon="mdi-auto-fix"></v-icon> Created
                            By:</strong
                        >
                        {{ modalDocDetails.created_by }}
                    </v-col>
                </v-row>

                <v-divider></v-divider>
                <v-row>
                    <v-col cols="12" class="py-1"
                        ><strong style="color: brown" class="text-success"
                            >Generated Documents</strong
                        >
                        <span v-for="document in modalDocDetails.documents">
                            <li
                                v-if="document.is_document_generated === 'yes'"
                                style="list-style-type: none"
                            >
                                <v-icon
                                    icon="mdi-check-circle"
                                    color="success"
                                    size="small"
                                ></v-icon>
                                {{ document.document_name }}
                            </li>
                        </span>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" @click="dialogVisible = false"
                    >Close</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";
import axios from "axios";

const selectedStudents = ref([]);
const selectedDocuments = ref([]);
const search = ref(null);
let passStatus = ref("");
const docType = ref("");
const documents = ref([]);
const students = ref([]);
const modalDocDetails = ref([]);
const dialogVisible = ref(false);
const pageNumber = ref(1);
const filterByPassStatus = ref("");
const filterByGeneratedStatus = ref("");
const toast = useToast();
let debounceTimeout = null;

const props = defineProps({
    students: {
        type: Object,
        required: true,
    },
});

watch(
    () => props.students,
    (newVal) => {
        students.value = newVal;
    },
    { immediate: true }
);

// ============================Search, Filter & Pagination ============================

// Watch the search query and debounce the API call
watch(search, (newVal) => {
    console.log("Search query changed:", newVal);
    pageNumber.value = 1;

    if (debounceTimeout) clearTimeout(debounceTimeout);

    debounceTimeout = setTimeout(() => {
        getFilteredData();
    }, 500);
});

//filter by pass status
watch(filterByPassStatus, (newVal) => {
    console.log("Filter by pass status:", newVal);
    pageNumber.value = 1;
    getFilteredData();
});
//filter by pass status
watch(filterByGeneratedStatus, (newVal) => {
    console.log("Filter by Generated Status:", newVal);
    pageNumber.value = 1;
    getFilteredData();
});

//pagination
const updatePageNumber = (link) => {
    pageNumber.value = link.url.split("=")[1];
    getFilteredData();
};

//main function
const getFilteredData = () => {
    axios
        .get("/marksheet/search", {
            params: {
                query: search.value,
                page: pageNumber.value,
                pass_status: filterByPassStatus.value,
                generated_status: filterByGeneratedStatus.value,
            },
        })
        .then((response) => {
            console.log(response);
            students.value = response.data.students;
        })
        .catch((error) => {
            toast.error(error.response.data.error);
        });
};

// ============================ Post Tracking Id ======================
const postTrackingId = (studentId) => {
    router.visit(`/shipment/student/${studentId}`);
};

//================================================================

watch(selectedStudents, (newVal) => {
    console.log("Selected students:", newVal);
});

watch(selectedDocuments, (newVal) => {
    console.log("Selected documents:", newVal);
});

//=========================== Get student Details and Show Data =================
const getStudentDocumentDetails = (studentData) => {
    modalDocDetails.value = studentData;
    dialogVisible.value = true;
};

// ========================== Fetching Documents =====================
const fetchDocs = () => {
    console.log(docType.value);
    axios
        .get("/marksheet/documents", {
            params: {
                doc_type: docType.value,
            },
        })
        .then((response) => {
            console.log(response);
            documents.value = response.data.map((doc) => doc.document_name);
        })
        .catch((error) => {
            toast.error(error.response.data.error);
        });
};

//=========================== Update Document =================
const generateDocument = () => {
    if (confirm("Are you sure you want to update")) {
        console.log("User confirmed the update");
    } else {
        console.log("User canceled the update");
        return;
    }
    console.log("Form has gone through the update: ", docType.value);
    axios
        .post("/marksheet/update-documents", {
            doc_type: docType.value,
            docs: selectedDocuments.value,
            students: selectedStudents.value,
        })
        .then((response) => {
            console.log(response);
            toast.success("Documents updated successfully!");
            selectedDocuments.value = [];
            selectedStudents.value = [];
            docType.value = "";
            getFilteredData();
        })
        .catch((error) => {
            selectedDocuments.value = [];
            selectedStudents.value = [];
            docType.value = "";
            toast.error(error.response.data.error);
        });
};

//============================ Update Pass Status =============================

const updatePassStatus = () => {
    if (confirm("Are you sure you want to update?")) {
        console.log("User confirmed the update.");
    } else {
        console.log("User canceled the update.");
        return;
    }

    axios
        .post("/marksheet/update-pass-status", {
            students: selectedStudents.value,
            pass_status: passStatus.value,
        })
        .then((response) => {
            console.log(response);
            toast.success("Pass status updated successfully!");
            selectedStudents.value = [];
            passStatus.value = "";
            getFilteredData();
        })
        .catch((error) => {
            selectedStudents.value = [];
            passStatus.value = "";
            toast.error(error.response.data.error);
        });
};
//==============================================================================
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

.pass-status-dropdown {
    width: 150px; /* Adjust width as needed */
    padding: 8px; /* Padding inside the dropdown */
    font-size: 14px; /* Font size */
    border: 2px solid #d1d5db; /* Light gray border */
    border-radius: 4px; /* Slightly rounded corners */
    background-color: white; /* White background */
    color: #374151; /* Text color */
    outline: none; /* Remove default outline */
    cursor: pointer; /* Change cursor on hover */
    transition: border-color 0.2s ease, box-shadow 0.2s ease; /* Smooth transitions */
}

/* Hover state */
.pass-status-dropdown:hover {
    border-color: #4b5563; /* Darker gray border on hover */
}

/* Focus state */
.pass-status-dropdown:focus {
    border-color: #2563eb; /* Blue border on focus */
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3); /* Blue shadow on focus */
}

.mello-yellow {
    background: linear-gradient(90deg, #f8ff00 0%, #3ad59f 100%);
}

.par-four {
    background: linear-gradient(90deg, #9ebd13 0%, #008552 100%);
}

.v-field__input {
    padding-top: 0px !important;
}

::v-deep .v-text-field .v-field--no-label input {
    opacity: 0 !important;
}
.custome-badge {
    padding: 3px 7px 3px !important;
    font-size: 11px !important;
    cursor: pointer;
}
.marksheet-table {
    border-collapse: collapse;
    width: 100%;
}

.marksheet-table td,
.marksheet-table th {
    border: 1px solid #f0efff;
    padding: 8px;
}

.marksheet-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.marksheet-table tr:hover {
    background-color: #ddd;
}

.marksheet-table th {
    padding-top: 3px;
    padding-bottom: 3px;
    text-align: left;
    background-color: #4f49a4;
    color: white !important;
    padding-left: 9px !important;
}
select.border.border-white.text-sm.rounded {
    border-color: #fff !important;
    background: #f7f7f7;
    color: #000;
}
.custom-title {
    font-weight: 600;
    font-size: 16px;
    color: #4C1F7A;
}
</style>
