<script setup>
import { ref, defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['students']);

const students = ref(props.students);
</script>



<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students Management System</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Students Table</h2>
                    </div>
                    <div class="card-body">
                        <Link href="/student/create" class="btn btn-success btn-sm" title="Add New Student">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </Link>

                        <br />
                        <br />
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in students" :key="student.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ student.name }}</td>
                                        <td>{{ student.dob }}</td>
                                        <td>
                                            <a :href="`/student/${student.id}`" class="btn btn-sm"
                                                :class="student.status ? 'btn-danger' : 'btn-success'">
                                                {{ student.status ? 'Inactive' : 'Active' }}
                                            </a>
                                        </td>
                                        <td>
                                            <Link :href="`/student/${student.id}/show`" title="View Student" style="margin: 5px;">
                                            <button class="btn btn-info btn-sm">
                                                <i class="fa fa-eye" aria-hidden="true"></i> View
                                            </button>
                                            </Link>
                                            <Link :href="`/student/${student.id}/edit`" title="Edit Student" style="margin: 5px;">
                                            <button class="btn btn-primary btn-sm">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                            </button>
                                            </Link>
                                            <form style="display:inline"
                                                @submit.prevent="$inertia.delete(`#`)" >
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    title="Delete Student" onclick="return confirm('Confirm delete?')">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>