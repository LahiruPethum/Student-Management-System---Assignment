<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";


const toast = useToast();


const form = useForm({
    name: null,
    dob: null,
    image: null,
});

function submit() {
    form.post('/student/store', {
        onSuccess: () => {
            toast.success('Student is created successfully..!')
        }
    });
}

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
                    <div class="card-header">Create student</div>
                    <div class="card-body">
                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" v-model="form.name" id="name" class="form-control" >
                                <span v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</span>

                            </div><br/>
                            
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" v-model="form.dob" id="dob" class="form-control">
                                <span v-if="form.errors.dob" class="text-danger">{{ form.errors.dob }}</span>

                            </div><br/>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" id="image" @input="form.image = $event.target.files[0]" class="form-control">
                                <span v-if="form.errors.image" class="text-danger">{{ form.errors.image }}</span>

                            </div><br/>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
