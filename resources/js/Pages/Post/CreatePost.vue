<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    posts: Array,
});
</script>

<template>
    <Head title="Post" />

    <AuthenticatedLayout>
        <div class="w-full px-20">
            <h1>Create Post</h1>
            <form @submit.prevent="handleSubmit" class="p-4 space-y-4">
                <!-- Input File -->
                <div>
                    <label for="file" class="block font-semibold">Post</label>
                    <input
                        id="file"
                        type="file"
                        accept="image/png, image/jpeg, image/jpg, video/mp4, video/mov"
                        @change="(e) => (file = e.target.files[0])"
                        class="border p-2 w-full"
                    />
                </div>

                <!-- Input Caption -->
                <div>
                    <label for="caption" class="block font-semibold"
                        >Caption</label
                    >
                    <input
                        id="caption"
                        type="text"
                        v-model="caption"
                        placeholder="Tambahkan caption..."
                        class="border p-2 w-full"
                    />
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="bg-blue-500 text-white p-2 rounded"
                >
                    Upload
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
