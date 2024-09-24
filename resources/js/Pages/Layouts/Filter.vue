<template>
    <v-form>
        <v-row>
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
                    <label for="floatingSelect">Select ExamCycle</label>
                </div>
            </v-col>
            <v-col cols="12" md="4">
                <v-form
                @submit.prevent="fileUpload"
                >
                <v-row class="align-center">
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
                </v-form>
            </v-col>
            <v-col cols="3" class="d-flex align-self-center">
                <v-btn class="ooey-gooey text-white" :href="'/sample_format.csv'">Download Sample Format</v-btn>
            </v-col>
        </v-row>
    </v-form>

    <!-- Data and Display -->

    <v-card
    title="Marksheet Data and Display"
    flat
  >

    <DataTable :students="students"></DataTable>
    <!-- <Pagination :students="students"></Pagination> -->


    <!-- ======================================= pagination ends here ================================= -->

  </v-card>

     <!-- End Data and Display -->
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable.vue'
import { ref, computed, watch, reactive, onMounted } from 'vue';
import axios from 'axios';

const departments = ref([]);
const batches = ref([]);
const examCycles = ref([]);
const isLoading = ref(true);

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
    })
    .catch(error => {
        console.log(error);
        csvFile.value = null;
        alert('Error: ' + error.message);
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
</style>
