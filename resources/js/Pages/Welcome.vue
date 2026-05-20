<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />
    
    <div class="min-h-screen flex flex-col bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <Link class="text-2xl font-bold text-blue-600" href="/">
                        URL Shortener
                    </Link>
                    <div class="flex items-center space-x-4">
                        <template v-if="canLogin">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link :href="route('login')" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                    Log in
                                </Link>
                                <Link v-if="canRegister" :href="route('register')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150">
                                    Register
                                </Link>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow flex items-center py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-5xl font-extrabold text-gray-900 mb-6 tracking-tight">
                        Shorten Your Links, <span class="text-blue-600">Expand Your Reach</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                        A powerful and simple URL shortener for your business and personal needs. 
                        Track your clicks and manage your links with ease.
                    </p>
                    
                    <div v-if="!$page.props.auth.user" class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Ready to start?</h3>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <Link :href="route('register')" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition duration-150 shadow-lg shadow-blue-200">
                                Create Free Account
                            </Link>
                            <Link :href="route('login')" class="bg-white hover:bg-gray-50 text-gray-700 px-8 py-4 rounded-xl font-bold text-lg border-2 border-gray-200 transition duration-150">
                                Login to Dashboard
                            </Link>
                        </div>
                    </div>
                    <div v-else class="text-center">
                        <Link :href="route('dashboard')" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-xl font-bold text-lg transition duration-150 shadow-lg shadow-blue-200 inline-block">
                            Go to Dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </main>

        <!-- Features -->
        <section class="py-20 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-12 text-center">
                    <div class="space-y-4">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto text-3xl">
                            ⚡
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Fast & Simple</h3>
                        <p class="text-gray-600">Shorten links in seconds and share them anywhere instantly.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto text-3xl">
                            📊
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Analytics</h3>
                        <p class="text-gray-600">Track how many times your links have been clicked in real-time.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto text-3xl">
                            🛡️
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Secure</h3>
                        <p class="text-gray-600">Your data is safe with our robust authentication system.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-8 bg-gray-50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
                <p>&copy; 2024 URL Shortener. Built with Laravel, Inertia, and Vue.</p>
            </div>
        </footer>
    </div>
</template>
