<script setup>
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';

const page = usePage(); // Get the page props, including query string parameters
const classId = ref(page.props.classId);

const data = ref(null);
const loading = ref(false);

let selectedDate = ref(window.localStorage.getItem('selectedDate'));
// Format Y-m-d
selectedDate = (new Date(selectedDate.value)).toISOString().slice(0, 10);

const fetchData = async () => {
    try {
        loading.value = true;

        const response = await axios.get(route('api.class.show', { "classId": classId.value }));

        data.value = response.data;
    } catch (error) {
        // Todo
        console.error('Error fetching data:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(fetchData);

</script>

<template>
    <Head title="Class" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <Link
                    :href="route('timetable.index', { date: selectedDate })"
                    class="underline text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    My Timetable
                </Link>

                &gt; Class <span v-if="!loading && data">{{ data.name }}</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <!-- Display the loading spinner when loading is true -->
                        <div v-if="loading" class="text-center mt-4">
                            <i class="fas fa-spinner fa-spin"></i> Loading...
                        </div>

                        <div v-if="data">
                            <h3>Class <span v-if="!loading && data">{{ data.name }}</span></h3>

                            <div class="flex-auto">
                                <h3 class="pr-10 font-semibold text-gray-900 xl:pr-0"></h3>
                                <dl class="mt-2 flex flex-col text-gray-500 xl:flex-row">
                                    <div class="flex space-x-3">
                                        <dd>
                                            <span v-if="data.description !== data.name">{{ data.description }}</span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div v-if="data.students && data.students.length > 0">
                                <h3>Students</h3>
                                <ol>
                                    <li v-for="(student, index) in data.students" :key="index" class="shadow-sm sm:rounded-lg relative flex space-x-6 py-6 xl:static bg-gray-300 m-6 pl-4">
                                        <div class="flex-auto">
                                            <h3 class="pr-10 font-semibold text-gray-900 xl:pr-0 pl-4">
                                                <i class="fas fa-user p-6 bg-gray-50 shadow-sm sm:rounded-lg"></i>

                                            </h3>
                                            <dl class="mt-2 flex flex-col text-gray-500 xl:flex-row">
                                                <div class="flex space-x-3">
                                                    <dd>
                                                        {{ student.surname }}, {{ student.forename }}
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div v-else>
                            <p v-if="!loading" class="bg-red-50 mt-6">No class data available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
