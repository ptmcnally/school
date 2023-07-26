<script setup>
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';

import {onMounted, ref} from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const page = usePage(); // Get the page props, including query string parameters
const selectedDate = ref(page.props.date || new Date()); // Initialize with the date from the query string or the current date
const data = ref(null);
const loading = ref(false); // Initialize loading state as false

const format = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `Selected date: ${day}/${month}/${year}`;
}

const fetchData = async () => {
    try {
        loading.value = true;

        const response = await axios.get(route('api.timetable.lessons'), {
            params: {
                date: selectedDate.value,
                userId: page.props.auth.user.wonde_employee_id
            },
        });

        window.localStorage.setItem('selectedDate', selectedDate.value);

        // Update the data variable with the response data
        data.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    } finally {
        // Set loading state to false after the API call is completed (success or error)
        loading.value = false;
    }
};

onMounted(fetchData);

</script>

<template>
    <Head title="Timetable" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Timetable</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="justify-center mb-4">
                    <Datepicker
                        v-model="selectedDate"
                        :enable-time-picker="false"
                        :format="format"
                        @update:model-value="fetchData"
                    />
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <h3>Lesson Schedule</h3>

                        <!-- Display the loading spinner when loading is true -->
                        <div v-if="loading" class="text-center mt-4">
                            <i class="fas fa-spinner fa-spin"></i> Loading...
                        </div>

                        <!-- Check if data is not null and loop through each item using v-for -->
                        <div v-if="data && data.length > 0">
                            <ol>
                                <li v-for="(item, index) in data" :key="index" class="shadow-sm sm:rounded-lg relative flex space-x-6 py-6 xl:static bg-gray-300 m-6 pl-4">
                                    <div class="flex-auto">
                                        <h3 class="pr-10 font-semibold text-gray-900 xl:pr-0">{{ item.start_time }} - {{ item.end_time }}</h3>
                                        <dl class="mt-2 flex flex-col text-gray-500 xl:flex-row">
                                            <div class="flex space-x-3">
                                                <dd>
                                                    <Link
                                                        :href="route('classes.show', { classId: item.classId })"
                                                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                    >
                                                        {{ item.className }}
                                                    </Link>
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <!-- If data is null or empty, display a message -->
                        <div v-else>
                            <p v-if="!loading" class="bg-red-50 mt-6">No lessons for the selected date.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
