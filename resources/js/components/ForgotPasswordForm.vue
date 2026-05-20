<template>
  <div class="w-full md:w-3/4 px-8 py-12">
    <h2 class="text-2xl font-bold text-left mb-6">Forgot Password</h2>

    <!-- Step 1: Send Reset Code -->
    <form @submit.prevent="sendResetLink" v-if="!otpSent" class="space-y-4">
      <div v-if="errors.length" class="bg-red-500 text-white p-3 rounded-lg">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <div>
        <label for="email" class="text-gray-600 text-sm block mb-1">Email</label>
        <input type="email" id="email" v-model="email" placeholder="Your registered email"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <button type="submit"
        class="w-full p-3 text-white font-bold rounded-lg bg-gradient-to-r from-[#007AFF] to-[#00D26A] shadow-md hover:opacity-90 transition duration-300"
        :disabled="loading">
        <span v-if="loading">Sending...</span>
        <span v-else>Send Reset Code</span>
      </button>

      <p class="text-gray-600 text-xs text-left mt-2">
        Remember your password? <a href="/login" class="text-blue-500 font-bold">Login</a>
      </p>
      <p class="text-gray-600 text-xs text-left">
        Don't have an account? <a href="/register" class="text-blue-500 font-bold">Register</a>
      </p>
    </form>

    <!-- Combined Step 2+3: OTP and Password -->
    <form @submit.prevent="verifyAndReset" v-if="otpSent" class="space-y-4">
      <div v-if="errors.length" class="bg-red-500 text-white p-3 rounded-lg">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <div v-if="success" class="bg-green-500 text-white p-3 rounded-lg">
        {{ success }}
      </div>

      <div>
        <p class="text-gray-600 mb-4">A 5-digit verification code has been sent to {{ email }}</p>
        <label for="otp" class="text-gray-600 text-sm block mb-1">Verification Code</label>
        <input type="text" id="otp" v-model="otp" placeholder="Enter 5-digit code" maxlength="5"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
          inputmode="numeric" pattern="[0-9]*">
      </div>

      <div>
        <label for="password" class="text-gray-600 text-sm block mb-1">New Password</label>
        <input type="password" id="password" v-model="password" placeholder="New Password"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label for="password_confirmation" class="text-gray-600 text-sm block mb-1">Confirm New Password</label>
        <input type="password" id="password_confirmation" v-model="password_confirmation"
          placeholder="Confirm New Password"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <button type="submit"
        class="w-full p-3 text-white font-bold rounded-lg bg-gradient-to-r from-[#007AFF] to-[#00D26A] shadow-md hover:opacity-90 transition duration-300"
        :disabled="loading">
        <span v-if="loading">Processing...</span>
        <span v-else>Verify & Reset Password</span>
      </button>

      <div class="flex justify-between text-gray-600 text-xs">
        <p>
          <button type="button" @click="resendOtp" class="text-blue-500 font-bold">
            Resend Code
          </button>
        </p>
        <p>
          <button type="button" @click="startOver" class="text-blue-500 font-bold">
            Start Over
          </button>
        </p>
      </div>
    </form>
  </div>
</template>

<script>
import { useToast } from 'vue-toastification';

export default {
  name: 'ForgotPasswordForm',
  data() {
    return {
      email: '',
      otp: '',
      password: '',
      password_confirmation: '',
      errors: [],
      success: '',
      loading: false,
      otpSent: false,
    };
  },
  setup() {
    const toast = useToast();
    return { toast };
  },
  methods: {
    sendResetLink() {
      this.errors = [];
      this.success = '';

      if (!this.email) {
        this.errors.push('Email is required');
        this.toast.error('Please enter your email address');
        return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.email)) {
        this.errors.push('Please enter a valid email address');
        this.toast.error('Please enter a valid email address');
        return;
      }

      this.loading = true;

      fetch('/api/forgot-password', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
        },
        body: JSON.stringify({ email: this.email }),
      })
        .then(response => response.json())
        .then(data => {
          this.loading = false;
          if (data.errors) {
            for (const field in data.errors) {
              this.errors.push(...data.errors[field]);
            }
            this.toast.error('Failed to send code');
          } else {
            this.success = data.message;
            this.toast.success(this.success);
            this.otpSent = true;
          }
        })
        .catch(error => {
          this.loading = false;
          this.toast.error('Error sending reset code');
          console.error(error);
        });
    },

    verifyAndReset() {
      this.errors = [];
      this.success = '';

      if (!this.otp || this.otp.length !== 5 || !/^\d+$/.test(this.otp)) {
        this.errors.push('Invalid 5-digit verification code');
        this.toast.error('Enter a valid 5-digit code');
        return;
      }

      if (!this.password || this.password.length < 8) {
        this.errors.push('Password must be at least 8 characters');
        this.toast.error('Password too short');
        return;
      }

      if (this.password !== this.password_confirmation) {
        this.errors.push('Passwords do not match');
        this.toast.error('Password mismatch');
        return;
      }

      this.loading = true;

      fetch('/api/reset-password', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          email: this.email,
          otp: this.otp,
          password: this.password,
          password_confirmation: this.password_confirmation,
        }),
      })
        .then(response => response.json())
        .then(data => {
          this.loading = false;
          if (data.errors) {
            for (const field in data.errors) {
              this.errors.push(...data.errors[field]);
            }
            this.toast.error('Failed to reset password');
          } else {
            this.success = data.message || 'Password reset successfully';
            this.toast.success(this.success);
            setTimeout(() => {
              window.location.href = '/login';
            }, 2000);
          }
        })
        .catch(error => {
          this.loading = false;
          this.toast.error('Error resetting password');
          console.error(error);
        });
    },

    resendOtp() {
      this.sendResetLink();
    },

    startOver() {
      this.email = '';
      this.otp = '';
      this.password = '';
      this.password_confirmation = '';
      this.errors = [];
      this.success = '';
      this.otpSent = false;
    },
  },
};
</script>
