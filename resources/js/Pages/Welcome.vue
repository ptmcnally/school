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
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <img src="/images/school-logo.png" alt="School Logo" />
            </div>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non tincidunt est. Quisque augue orci, commodo eu mi vitae, finibus sodales nisl. Cras eget libero ut dolor faucibus tempor. Sed at ultrices magna. Praesent eu tempor erat. Nullam quis egestas nunc. Cras tempus, nunc eleifend pellentesque vestibulum, ligula enim dictum magna, eget vestibulum dolor neque eu lorem. In sed lacus nisi. Nullam porta lacinia diam, vel consectetur nibh lacinia in. Nunc malesuada nisl sem, eget fermentum erat molestie quis. Pellentesque eu convallis velit, vitae lacinia sapien. Sed mollis purus eget diam iaculis, at accumsan velit hendrerit. Duis nec arcu vitae ipsum dignissim semper.
                </p>

                <p>
                    Phasellus eget arcu leo. Nam nisl sapien, laoreet id mi sed, cursus tempus metus. Donec ac fringilla lacus. Curabitur sed consequat mauris. Proin tempus sem at sollicitudin feugiat. Morbi ultricies posuere sapien at facilisis. Sed nec erat interdum, lobortis sapien vitae, eleifend metus.
                </p>

                <p>
                    Aenean nulla enim, iaculis ut sodales vitae, congue quis lectus. Nam nec massa nibh. Pellentesque eu purus faucibus, vehicula est non, venenatis massa. Phasellus ultricies cursus nisl, sit amet commodo nulla mollis id. Integer ornare varius risus, quis pretium massa luctus id. In mollis enim id iaculis euismod. Suspendisse finibus nibh ac ultricies tincidunt. Nunc pellentesque vel dolor in tempus. Maecenas faucibus nisi turpis, a mollis velit congue vitae. Vestibulum ut ante vel orci imperdiet fermentum. Sed commodo in sem vehicula vestibulum. Phasellus luctus venenatis metus dapibus commodo. Praesent nunc lectus, auctor quis pretium ut, ornare vitae nisl.
                </p>

            </div>
        </div>

    </div>
</template>

<style>
p {
    margin-top: 1rem;
}
</style>
