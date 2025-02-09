<script setup>
import { ref, watch } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    posts: Array,
    setting: Object,
});

const userData = usePage().props.auth.user;
console.log(`user: ${userData.avatar}`);
const fpr = ref(props.setting.feed_per_row);
const debouncedFPR = ref("");

let debounceTimer = null;

watch(fpr, (newValue) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        debouncedFPR.value = newValue;
        formSetting.feed_per_row = debouncedFPR.value
        formSetting.post('/settings')
    }, 500); // Delay 500ms
});

const isChangeAvatar = ref(false);
const isChangeProfile = ref(false);

const user = ref({
    username: userData.username,
    bio: userData.bio,
});

const formSetting = useForm({
    feed_per_row: debouncedFPR.value,
})
</script>

<template>
    <Head title="Post" />

    <AuthenticatedLayout>
        <div class="w-full px-20">
            <h1 class="mb-5 text-2xl font-bold">Setting</h1>
            <div class="py-4 my-4 border-b-slate-300 border-b-2">
                <label for="caption" class="block font-semibold"
                    >Feed Per Row</label
                >
                <input
                    id="feedPerRow"
                    type="number"
                    v-model="fpr"
                    class="border p-2 w-full"
                />
            </div>
            <div>
                <h1 class="mb-5 text-2xl font-bold">Edit Profile</h1>
                <div>
                    <div v-if="!isChangeAvatar">
                        <img class="w-32 h-32 rounded-full object-cover" :src="userData.avatar" alt="avatar">
                        <button class="bg-blue-500 text-white p-2 rounded" @click="isChangeAvatar = true">Change Avatar</button>
                    </div>
                    <div v-else>
                        <h3 class="text-lg mb-3">Change Avatar</h3>
                        <form @submit.prevent="handleSubmit">
                            <div>
                                <label for="file" class="block font-semibold"
                                    >Avatar</label
                                >
                                <input
                                    id="file"
                                    type="file"
                                    accept="image/png, image/jpeg, image/jpg"
                                    @change="(e) => (file = e.target.files[0])"
                                    class="border p-2 w-full"
                                />
                            </div>
                            <!-- Buttons -->
                            <div class="flex justify-end space-x-2">
                                <button
                                    type="button"
                                    class="bg-gray-300 p-2 rounded"
                                    @click="isChangeAvatar = false"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="bg-blue-500 text-white p-2 rounded"
                                >
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg mb-3">Profile Information</h3>
                    <form v-if="isChangeProfile" @submit.prevent="handleSubmit" >
                        <div>
                            <label for="username" class="block font-semibold"
                                >Username</label
                            >
                            <input
                                id="username"
                                type="text"
                                v-model="user.username"
                                class="border p-2 w-full"
                            />
                        </div>
                        <div>
                            <label for="bio" class="block font-semibold"
                                >Bio</label
                            >
                            <textarea
                                id="bio"
                                type="text"
                                v-model="user.bio"
                                class="border p-2 w-full"
                            />
                        </div>
                        <!-- Buttons -->
                        <div class="flex justify-end space-x-2">
                            <button
                                type="button"
                                class="bg-gray-300 p-2 rounded"
                                @click="isChangeProfile = false"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                class="bg-blue-500 text-white p-2 rounded"
                            >
                                Upload
                            </button>
                        </div>
                    </form>
                    <div v-else class="flex justify-between">
                        <div>
                            <p><span class="font-semibold">Username</span>: {{ user.username }}</p>
                            <p><span class="font-semibold">Bio</span>: {{ user.bio ?? "please input your bio !!" }}</p>
                        </div>
                        <button class="bg-blue-500 text-white p-2 rounded" @click="isChangeProfile = true">Edit</button>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
