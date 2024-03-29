<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";

const props = defineProps(['student']);
const toast = useToast();
const form = useForm({
    name: props.student.name,
    dob: props.student.dob,
    image: null,
});

function submit() {
    form.post(`/student/${props.student.id}/update`, {
        onSuccess: () => {
            toast.success('Student is updated successfully..!')
        }
    })
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
                    <div class="card-header">Edit student</div>
                    <div class="card-body">
                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label><br>
                                <input type="text" v-model="form.name" class="form-control" >
                                <span v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</span>
                            </div><br />

                            <div class="form-group">
                                <label>Date of Birth</label><br>
                                <input type="date" v-model="form.dob" ><br>
                                <span v-if="form.errors.name" class="text-danger">{{ form.errors.dob }}</span>
                            </div><br />

                            <div class="form-group">
                                <label>Image</label><br>
                                <input type="file" @change="handleFileUpload"><br><br><br>
                            </div><br />

                            <input type="submit" value="Update" class="btn btn-success">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
