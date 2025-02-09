<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 flex">
            <!-- sidebar -->
            <div class="bg-blue-500 w-1/6 text-center flex flex-col">
                <h3 class="mt-5 text-xl font-semibold text-white">InstaLight</h3>
                <nav class="mt-10 text-lg font-medium text-white w-full">
                    <Link class="hover:bg-blue-700 w-full" :href="route('profile.index')">Profile</Link>
                    <Link class="hover:bg-blue-700 w-full" :href="route('logout')" method="post" as="button">Logout</Link>
                </nav>
            </div>


            <!-- Page Content -->
            <main class="w-5/6 mt-10">
                <slot />
            </main>
        </div>
    </div>
</template>
