<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
});

const baseUrl = window.location.origin;

const form = useForm({
    original_url: '',
});

const submit = () => {
    form.post(route('links.store'), {
        onSuccess: () => form.reset(),
    });
};

const deleteLink = (id) => {
    if (confirm('Are you sure you want to delete this link?')) {
        useForm({}).delete(route('links.destroy', id));
    }
};

const copyToClipboard = (code) => {
    const url = window.location.origin + '/' + code;
    navigator.clipboard.writeText(url);
    alert('Copied to clipboard: ' + url);
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Shortened Links
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Shorten Form -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Shorten a New URL</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Enter your long URL below to create a shortened version.
                        </p>
                    </header>

                    <form @submit.prevent="submit" class="mt-6 flex flex-col sm:flex-row gap-4">
                        <div class="flex-grow">
                            <input 
                                v-model="form.original_url" 
                                type="url" 
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                placeholder="https://example.com/very/long/url" 
                                required
                            >
                            <div v-if="form.errors.original_url" class="mt-2 text-sm text-red-600">
                                {{ form.errors.original_url }}
                            </div>
                        </div>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            :disabled="form.processing"
                        >
                            Shorten
                        </button>
                    </form>
                </div>

                <!-- Links Table -->
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Original URL</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Short Link</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Visits</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-widest">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="link in links" :key="link.id" class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="max-w-xs truncate" :title="link.original_url">
                                            <a :href="link.original_url" target="_blank" class="text-blue-600 hover:underline">{{ link.original_url }}</a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-mono text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                                {{ baseUrl }}/{{ link.short_code }}
                                            </span>
                                            <button 
                                                @click="copyToClipboard(link.short_code)" 
                                                class="text-gray-400 hover:text-gray-600"
                                                title="Copy to clipboard"
                                            >
                                                📋
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ link.visits }} visits
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button 
                                            @click="deleteLink(link.id)" 
                                            class="text-red-600 hover:text-red-900 ml-4"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="links.length === 0">
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        No links found. Start by shortening one!
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
