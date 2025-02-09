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

import { ref } from "vue";

// Data Dummy
const archiveData = ref([
    {
        id: 1,
        type: "image",
        url: "https://via.placeholder.com/150",
        date: "2024-02-01",
        caption: "Beautiful Sunset",
    },
    {
        id: 2,
        type: "video",
        url: "https://www.w3schools.com/html/mov_bbb.mp4",
        date: "2024-02-02",
        caption: "My Trip to Bali",
    },
    {
        id: 3,
        type: "image",
        url: "https://via.placeholder.com/150",
        date: "2024-02-05",
        caption: "Lovely Cat",
    },
    {
        id: 4,
        type: "image",
        url: "https://via.placeholder.com/150",
        date: "2024-02-10",
        caption: "Snowy Mountain",
    },
]);

const startDate = ref("");
const endDate = ref("");
const filteredData = ref([...archiveData.value]);

// Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
const getTodayDate = () => {
    const today = new Date();
    return today.toISOString().split("T")[0];
};

// Fungsi untuk menerapkan filter berdasarkan kondisi
const applyFilter = () => {
    const today = getTodayDate();

    filteredData.value = archiveData.value.filter((post) => {
        if (startDate.value && endDate.value) {
            // Jika startDate dan endDate diisi, filter berdasarkan rentang
            return post.date >= startDate.value && post.date <= endDate.value;
        } else if (startDate.value) {
            // Jika hanya startDate diisi, tampilkan dari startDate sampai hari ini
            return post.date >= startDate.value && post.date <= today;
        } else if (endDate.value) {
            // Jika hanya endDate diisi, tampilkan semua data sebelum endDate
            return post.date <= endDate.value;
        }
        return true; // Jika tidak ada filter, tampilkan semua data
    });
};

// Fungsi untuk mensimulasikan download archive
const downloadArchive = (format) => {
    let message = `Archive downloaded with format ${format.toUpperCase()}`;

    if (startDate.value && endDate.value) {
        message += ` from date ${startDate.value} to date ${endDate.value}`;
    } else if (startDate.value) {
        message += ` from date ${startDate.value} to today`;
    } else if (endDate.value) {
        message += ` until date ${endDate.value}`;
    }

    console.log(message);
};
</script>

<template>
    <Head title="Post" />

    <AuthenticatedLayout>
        <div class="w-full px-20">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-4">Archive Page</h1>

                <!-- Download Buttons -->
                <div class="my-4">
                    <button
                        @click="downloadArchive('xlsx')"
                        class="bg-green-500 text-white px-4 py-2 rounded mr-2"
                    >
                        Download as XLSX
                    </button>
                    <button
                        @click="downloadArchive('pdf')"
                        class="bg-red-500 text-white px-4 py-2 rounded"
                    >
                        Download as PDF
                    </button>
                </div>

                <!-- Filter Tanggal -->
                <div class="mb-4 flex items-center space-x-4">
                    <label for="startDate" class="font-medium"
                        >Start Date:</label
                    >
                    <input
                        type="date"
                        id="startDate"
                        v-model="startDate"
                        class="border p-2 rounded"
                    />

                    <label for="endDate" class="font-medium">End Date:</label>
                    <input
                        type="date"
                        id="endDate"
                        v-model="endDate"
                        class="border p-2 rounded"
                    />

                    <button
                        @click="applyFilter"
                        class="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        Apply Filter
                    </button>
                </div>

                <!-- Table Data Archive -->
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Media</th>
                            <th class="border p-2">Date</th>
                            <th class="border p-2">Caption</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="post in filteredData" :key="post.id">
                            <td class="border p-2">
                                <img
                                    v-if="post.type === 'image'"
                                    :src="post.url"
                                    alt="Post Image"
                                    class="h-16 w-16 object-cover"
                                />
                                <video v-else class="h-16 w-16" controls>
                                    <source :src="post.url" type="video/mp4" />
                                    Your browser does not support the video tag.
                                </video>
                            </td>
                            <td class="border p-2">{{ post.date }}</td>
                            <td class="border p-2">{{ post.caption }}</td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </AuthenticatedLayout>
</template>
