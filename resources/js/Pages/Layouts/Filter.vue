<template>
   <v-sheet class="v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow mb-5 py-5">
    <v-form>
        <v-row class="pt-4">
            <v-col cols="12" md="3">
                <div class="form-floating mb-3">
                    <select v-model="form.department_id" name="department_id" id="department" class="select2 form-control">
                        <option v-if="isLoading">Loading ...</option>
                        <option v-else v-for="department in departments" :value="department.department_id">{{ department.department_name }}</option>
                    </select>
                    <label for="floatingSelect">Select Department</label>
                </div>
            </v-col>
            <v-col cols="12" md="3">
                <div class="form-floating mb-3">
                    <select v-model="form.program_id" name="program_id" id="programCreate" class="select2 form-control">
                        <option v-if="isLoading">Loading ...</option>
                        <option v-else v-for="program in programs" :value="program.program_id">{{ program.program }}</option>
                    </select>
                    <label for="floatingSelect">Select Programs</label>
                </div>
            </v-col>
            <v-col cols="12" md="3">
                <div class="form-floating mb-3">
                <select v-model="form.batch_id" name="batch_id" id="batchCreate" class="select2 form-control">
                    <option v-if="isLoading">Loading ...</option>
                    <option v-else v-for="batch in batches" :value="batch.batch_id">{{ batch.batch }}</option>
                </select>
                <label for="floatingSelect">Select Batch</label>
            </div>
            </v-col>
            <v-col cols="12" md="3">
                <div class="form-floating mb-3">
                    <select v-model="form.examCycle" name="semester_id" id="semesterCreate" class="select2 form-control">
                        <option v-if="isLoading">Loading ...</option>
                        <option v-else v-for="examCycle in examCycles" :value="examCycle.exam_cycle">{{ examCycle.exam_cycle }}</option>
                    </select>
                    <label for="floatingSelect">Select Exam Cycle</label>
                </div>
            </v-col>
            <v-col cols="12" md="12">
                <v-form
                @submit.prevent="fileUpload"
                >
                <v-row class="d-flex justify-content-center align-items-center">
                    <v-col cols="6" class="">
                     <!-- <v-btn class="" :href="'/sample_format.csv'">Download Sample Format</v-btn> -->
                     <a href="/sample_format.csv">
                     <v-alert
                        class="alert"
                        text="Please fill up the relevant details in the sample format provided in the link and then upload it.Click to download the sample file"
                        title="Note:"
                        border="start"
                        border-color="deep-purple accent-4"
                        elevation="2"
                        type=""
                    ></v-alert>
                    </a>
                    </v-col>
                    <v-col cols="6">
                    <v-row class="justify-content-center align-items-center">
                    <v-col cols="8">
                        <v-file-input
                            v-model="csvFile"
                            clearable
                            label="Upload CSV File ..."
                            variant="outlined"
                            accept=".csv"
                        ></v-file-input>
                    </v-col>
                    <v-col cols="4">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </v-col>
                </v-row>
                </v-col>
                </v-row>
                </v-form>
            </v-col>

        </v-row>
    </v-form>
</v-sheet>

    <!-- Data and Display -->
    <v-sheet class="v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow mb-5">
    <v-card title="Marksheet Data and Display" flat >

      <DataTable :students="students"></DataTable>
    <!-- <Pagination :students="students"></Pagination> -->


    <!-- ======================================= pagination ends here ================================= -->

  </v-card>
  </v-sheet>

     <!-- End Data and Display -->
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable.vue'
import { ref, computed, watch, reactive, onMounted } from 'vue';
import { useToast } from "vue-toastification";
import axios from 'axios';

const departments = ref([]);
const batches = ref([]);
const examCycles = ref([]);
const isLoading = ref(true);
const toast = useToast();

//============================ fetching programs and batches =============================
onMounted(()=>{
    axios.get('/fetch/Apis')
    .then(response => {
        isLoading.value = false;
        batches.value = response.data[0];
         departments.value = response.data[1];
         examCycles.value = response.data[2];
         console.log(departments, batches, examCycles);

    })
    .catch(error => {
         console.log(error);
     });
})

//================================= initializing =========================================
const programs = ref([]);

const form = useForm({
    department_id: null,
    program_id: null,
    batch_id: null,
    examCycle: null,
})

const csvFile = ref(null);
const students = ref([]);



// ============================== uploading marksheet files =============================
const fileUpload = () => {
    // Validation checks
    if (!csvFile.value) {
        alert('Please select a CSV file.');
        return;
    }
    if (!form.department_id) {
        alert('Please select a department.');
        return;
    }
    if (!form.program_id) {
        alert('Please select a program.');
        return;
    }
    if (!form.batch_id) {
        alert('Please select a batch.');
        return;
    }
    if (!form.examCycle) {
        alert('Please select an exam cycle.');
        return;
    }
    const formData = new FormData();
    formData.append('csv', csvFile.value);
    formData.append('department_id', form.department_id);
    formData.append('program_id', form.program_id);
    formData.append('batch_id', form.batch_id);
    formData.append('examCycle', form.examCycle);
    console.log(formData);
    axios.post('/marksheet/upload', formData,{
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
    .then(response => {
        students.value = response.data.students;
        csvFile.value = null;
        toast.success("Student Data uploaded successfully");
    })
    .catch(error => {
        console.log(error);
        csvFile.value = null;
        toast.error(error.message);
    });
}


//========================== getting programs =================
watch(()=>form.department_id, (departmentId)=>{
    isLoading.value = true;
    getPrograms(departmentId)
});

const getPrograms = (departmentId) => {
    axios.get(`/marksheet/programs/${departmentId}`)
    .then(response => {
        isLoading.value = false;
        programs.value = response.data;
    })
    .catch(error => {
        console.log(error);
        toast.error(error);
    });

}

</script>


<style>
.v-field__input {
    padding-top: 0px !important;
}

.ooey-gooey {
    background: linear-gradient(90deg, #0700b8 0%, #00ff88 100%);
}

.aqua-spray {
    background: linear-gradient(90deg, #00d2ff 0%, #3a47d5 100%);
}
.card-shadow{
    box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
    padding: 15px;
    background: #fff;
    border-radius: 12px;
}
.upload-icon {
    background: #324edf;
    width: 45px;
    height: 45px;
    font-size: 20px;
    border-radius: 50px;
    color: #fff;
}

.alert {
    text-decoration: underline;
    color: #007bff;
}
</style>
