<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';

import { ref, onMounted } from 'vue';

const currentTime = ref('');
const loading = ref(false); // Initialize loading state as false
const page = usePage(); // Get the page props, including query string parameters
const data = ref(null);


onMounted(() => {
    updateTime();
    setInterval(updateTime, 1000);
    fetchTimetableData();
});

function updateTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    currentTime.value = `${hours}:${minutes}`;
}

const fetchTimetableData = async () => {
    try {
        loading.value = true;

        const response = await axios.get(route('api.timetable.lessons'), {
            params: {
                date: new Date(),
                userId: page.props.auth.user.wonde_employee_id
            },
        });

        // Update the data variable with the response data
        data.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    } finally {
        // Set loading state to false after the API call is completed (success or error)
        loading.value = false;
    }
};

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $page.props.auth.user.role }}'s Dashboard</h2>
            <span class="float-right"><i class="fas fa-clock" style="color: #1a5fb4;"></i> {{ currentTime }}</span>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Hello {{ $page.props.auth.user.name }}

                        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                            <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">

                                <ul role="list" class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                                    <li class="overflow-hidden rounded-xl border border-gray-200">
                                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                                            <i class="fas fa-calendar h-120 w-120 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10"></i>
                                            <div class="text-sm font-medium leading-6 text-gray-900">Today's Timetable</div>
                                        </div>

                                        <div v-if="loading" class="text-center mt-4">
                                            <i class="fas fa-spinner fa-spin"></i> Loading...
                                        </div>

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
                                            <p v-if="!loading" class="bg-red-50 mt-6">No lessons today.</p>
                                        </div>

                                        <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                                            <div class="flex justify-center mb-2">
                                                <Link
                                                    :href="route('timetable.index')"
                                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                >
                                                    <button type="button" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                        View Full Timetable
                                                    </button>
                                                </Link>

                                            </div>
                                        </dl>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
