<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['student']);

const form = useForm({
    name: props.student.name,
    dob: props.student.dob,
    image: null,
});

function submit() {
    form.post(`/student/${props.student.id}/update`)
}

const handleFileUpload = (event) => {
    form.image = event.target.files[0];
};
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
                    <div class="card-header">Contact Us Page</div>
                    <div class="card-body">
                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <label>Name</label><br>
                            <input type="text" v-model="form.name" class="form-control" required><br>

                            <label>Date of Birth</label><br>
                            <input type="date" v-model="form.dob" required><br><br>

                            <label>Image</label><br>
                            <input type="file" @change="handleFileUpload"><br><br><br>

                            <input type="submit" value="Update" class="btn btn-success"><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
