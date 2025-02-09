<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import ProfileInformation from './Partials/ProfileInformation.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    posts: Array
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <div class="w-full px-20">
            edit profile page
        </div>
    </AuthenticatedLayout>
</template>
