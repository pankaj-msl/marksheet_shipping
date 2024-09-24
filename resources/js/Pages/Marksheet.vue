<template>
    <Header :data="{ client, admin }"></Header>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Marksheet Uploading Portal</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Marksheet Uploading</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <Filter></Filter>
                    <!-- <Filter :data="{ departments, batches, examCycles }"></Filter> -->
                </div>
            </div>
        </section>
    </main>
</template>

<script setup>
import Header from "./Layouts/Header.vue";
import Filter from "./Layouts/Filter.vue";
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
</script>
