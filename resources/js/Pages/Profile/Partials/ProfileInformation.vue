<script setup>
import { ref } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    post: Array,
});

console.log(`post: ${props.post[0].caption}`);
const user = usePage().props.auth.user;
console.log(`avatar: ${user}`);

// const form = useForm({
//     name: user.name,
//     email: user.email,
// });

const isOpen = ref(false);
const file = ref(null);
const caption = ref("");

const openModal = () => (isOpen.value = true);
const closeModal = () => (isOpen.value = false);

const handleSubmit = () => {
    // const formData = new FormData();
    // formData.append("file_path", this.form.file_path);
    // formData.append("caption", this.form);

    // console.log("File:", this.form.file_path);
    // console.log("Caption:", this.form.file_path);
    // form.file_type = form.file_path.type
    form.post('/posts');
    // console.log(form)

    // Setelah submit, tutup modal
    closeModal();
};

// feed
const isOpenPost = ref(false);
const selectedPost = ref(null);
const openModalPost = (item) => {
    selectedPost.value = item;
    isOpenPost.value = true;
};
const closeModalPost = () => {
    isOpenPost.value = false;
};

const form = useForm({
  caption: null,
  file_path: null,
  file_type: null
})

function submit() {
  form.post('/users')
}

</script>

<template>
    <section class="pb-4 border-b-4 mb-2 border-gray-300">
        <div class="flex mb-4">
            <img
                width="200"
                height="200"
                v-if="!user.avatar"
                src="images/profile-user.png"
                alt="profile"
            />
            <img
                class="rounded-full w-52 h-52 object-cover"
                v-else
                :src="user.avatar"
                alt="profile"
            />

            <div class="px-10">
                <div class="flex gap-5 items-center">
                    <h4 class="text-lg font-semibold">{{ user.username }}</h4>
                    <Link
                        :href="route('profile.edit')"
                        class="btn bg-slate-500 px-4 py-2 text-white rounded-md hover:bg-slate-600 transition duration-300 active:bg-slate-700"
                        >Edit Profile</Link
                    >
                    <Link
                        :href="route('posts.archive')"
                        class="btn bg-slate-500 px-4 py-2 text-white rounded-md hover:bg-slate-600 transition duration-300 active:bg-slate-700"
                        >View Archive</Link
                    >
                    <Link
                        :href="route('settings.index')"
                        class="btn bg-slate-500 px-4 py-2 text-white rounded-md hover:bg-slate-600 transition duration-300 active:bg-slate-700"
                        >Setting</Link
                    >
                </div>
                <div class="mt-4">
                    <p><span>3</span> posts</p>
                </div>
                <div>
                    <p>{{ user.name }}</p>
                    <p>{{ user.bio ? user.bio : "No description" }}</p>
                </div>
            </div>
        </div>
        <button
            @click="openModal"
            class="mt-4 btn bg-slate-500 px-4 py-2 text-white rounded-md hover:bg-slate-600 transition duration-300 active:bg-slate-700"
        >
            New Post
        </button>
    </section>
    <div class="mt-4 grid grid-cols-3">
        <img
            @click="openModalPost(postItem)"
            v-for="postItem in post"
            :src="`/storage/${postItem.file_path}`"
            alt="profile"
            :key="postItem.id"
            class="w-full h-full object-cover hover:brightness-75 transition duration-300"
        />
    </div>
    <!-- modal post -->
    <div
        v-if="isOpenPost"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2 h-1/2">
            <div class="flex gap-5">
                <img
                    :src="selectedPost.file_path"
                    class="w-full h-48 object-cover rounded mt-4"
                />
                <div>
                    <h2 class="text-xl font-bold">{{ selectedPost.caption }}</h2>
                    <p><strong>Age:</strong> post</p>

                </div>
            </div>
            <div>
                <div class="flex justify-end mt-4">
                    <button
                        @click="closeModalPost"
                        class="bg-red-500 text-white p-2 rounded"
                    >
                        Tutup
                    </button>
                    <button
                        @click="closeModalPost"
                        class="bg-slate-500 text-white p-2 rounded"
                    >
                        Archive
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div
        v-if="isOpen"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
    >
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl font-bold mb-4">Buat Postingan</h2>

            <!-- Form Upload -->
            <form @submit.prevent="handleSubmit" class="space-y-4">
                <div>
                    <label for="file" class="block font-semibold">Post</label>
                    <input
                        id="file"
                        type="file"
                        accept="image/png, image/jpeg, image/jpg, video/mp4, video/mov"
                        @input="form.file_path = $event.target.files[0]"
                        class="border p-2 w-full"
                    />
                </div>

                <div>
                    <label for="caption" class="block font-semibold"
                        >Caption</label
                    >
                    <input
                        id="caption"
                        type="text"
                        v-model="form.caption"
                        placeholder="Tambahkan caption..."
                        class="border p-2 w-full"
                    />
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-2">
                    <button
                        type="button"
                        @click="closeModal"
                        class="bg-gray-300 p-2 rounded"
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
</template>
