<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="InstaLight" />
    <div class="relative flex flex-col items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <h1 class="text-5xl font-bold mb-4">InstaLight</h1>
        <p class="text-2xl mb-4">This is the landing page for web Personal Light Intagram </p>
        <div class="flex gap-5">
            <Link :href="route('register')" class="btn bg-yellow-500 text-center text-xl px-5 py-3 rounded-md">Register</Link>
            <Link :href="route('login')" class="btn bg-blue-500 text-center text-xl px-5 py-3 rounded-md">Login</Link>
        </div>
    </div>


</template>

<style>

</style>
