
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    post: Object
});

const user = usePage().props.auth.user;
console.log(`post: ${props.post.file_path}`)

function formatDate(isoString) {
    const months = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const date = new Date(isoString);
    const day = date.getUTCDate();
    const month = months[date.getUTCMonth()];
    const year = date.getUTCFullYear();

    return `${day} ${month} ${year}`;
}

console.log(formatDate(props.post.created_at));
</script>

<template>
    <Head title="Feed" />

    <AuthenticatedLayout>
        <div class="w-full px-20">
            <div class="flex w-full">
                <img class="w-52 h-52" :src="post.file_path" alt="foto">
                <div class="border border-red-500 flex-grow px-5">
                    <div class="flex items-center gap-4">
                        <img class="w-10 h-10 rounded-full object-cover" :src="user.avatar" alt="avatar">
                        <p>{{ user.username }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <img class="w-10 h-10 rounded-full object-cover" :src="user.avatar" alt="avatar">
                        <p><span>
                            {{ user.username }}
                        </span> {{ post.description ? post.description : 'No description' }}</p>
                    </div>
                    <p>{{ formatDate(props.post.created_at) }}</p>
                    <button class="btn bg-slate-500 px-4 py-2 text-white rounded-md hover:bg-slate-600 transition duration-300 active:bg-slate-700">Archive</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


