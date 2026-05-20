<template>
    <!-- Root Element -->
    <div class="w-full md:w-3/4 px-8 py-12">
        <h2 class="text-2xl font-bold text-left mb-6">Login Page</h2>

        <form @submit.prevent="login" class="space-y-4">
            <div v-if="errors.length" class="bg-red-500 text-white p-3 rounded-lg">
                <ul>
                    <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                </ul>
            </div>

            <div>
                <label for="email" class="text-gray-600 text-sm block mb-1">Email</label>
                <input type="email" id="email" v-model="formData.email" placeholder="Email" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="password" class="text-gray-600 text-sm block mb-1">Password</label>
                <input type="password" id="password" v-model="formData.password" placeholder="Password" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <div class="flex justify-end mt-1">
                    <a href="/forgot-password" class="text-blue-500 text-xs font-medium">Forgot Password?</a>
                </div>
            </div>

            <button type="submit" 
                class="w-full p-3 text-white font-bold rounded-lg bg-gradient-to-r from-[#007AFF] to-[#00D26A] shadow-md hover:opacity-90 transition duration-300"
                :disabled="loading">
                <span v-if="loading">Logging in...</span>
                <span v-else>Login</span>
            </button>

            <p class="text-gray-600 text-xs text-left mt-2">
                Belum punya akun? <a href="/register" class="text-blue-500 font-bold">Register</a>
            </p>
        </form>

    </div>
</template>

<script>
import { useToast } from 'vue-toastification';

export default {
    name: 'LoginForm',
    data() {
        return {
            formData: {
                email: '',
                password: ''
            },
            errors: [],
            loading: false,
            logoUrl: '/images/logo.png',
            foodImageUrl: '/images/healthy-food.png'
        };
    },
    setup() {
        const toast = useToast();
        return { toast };
    },
    methods: {
        login() {
            this.errors = [];

            if (!this.formData.email) {
                this.errors.push('Email is required');
                this.toast.error('Please enter your email');
                return;
            }
            
            if (!this.formData.password) {
                this.errors.push('Password is required');
                this.toast.error('Please enter your password');
                return;
            }

            this.loading = true;

            fetch('/api/login', {
                method: 'POST',
                body: JSON.stringify(this.formData),
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                redirect: 'follow'
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (!data) return; // Handle redirect case
                
                this.loading = false;
                
                if (data.success === false && data.errors) {
                    // Handle validation errors
                    for (const field in data.errors) {
                        if (Array.isArray(data.errors[field])) {
                            data.errors[field].forEach(error => {
                                this.errors.push(error);
                            });
                        } else {
                            this.errors.push(data.errors[field]);
                        }
                    }
                    this.toast.error('Invalid credentials. Please check your email and password.');
                } else if (data.success === true && data.token) {
                    window.NutriAuth.setToken(data.token);
                    window.NutriAuth.applyAuthHeader();
                    this.toast.success('Login successful!');
                    window.location.href = '/dashboard';
                }
            })
            .catch(error => {
                this.loading = false;
                this.toast.error('An error occurred during login. Please try again.');
                console.error('Login error:', error);
            });
        }
    }
};
</script>
