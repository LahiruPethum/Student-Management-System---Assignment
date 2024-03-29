<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students Management System</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="card">
                    <div class="card-header">Students Page</div>
                    <div class="card-body">
                        <div class="card-body" style="text-align: center;">
                            <p>
                                <img v-if="student" :src="'/users/' + student.image"
                                    style="border-radius: 50%; height: 200px; width: 200px; margin: 0 auto;" alt="">

                            </p><br/>
                            <p class="card-title">Name : {{ student.name }}</p>
                            <p class="card-text">Date of Birth : {{ student ? student.dob : 'Loading...' }}</p>
                            <p class="card-text">Age : {{ age }}</p>
                            <p :class="student && student.status === 1 ? 'text-success' : 'text-danger'"
                                style="font-size: 15px; font-weight: 900;">
                                {{ student ? (student.status ? 'Active' : 'Inactive') : 'Loading...' }}
                            </p>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';


const props = defineProps(['student', 'age']);


</script>
