<template>
  <!-- Right Side (Form Content) -->
  <div class="w-full md:w-3/4 px-8 py-12">
    <h2 class="text-2xl font-bold text-left mb-6">Create Account</h2>

    <form @submit.prevent="register" class="space-y-4">
      <div v-if="errors.length" class="bg-red-500 text-white p-3 rounded-lg">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <div>
        <label for="name" class="text-gray-600 text-sm block mb-1">Name</label>
        <input
          type="text"
          id="name"
          v-model="formData.name"
          placeholder="Full Name"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="email" class="text-gray-600 text-sm block mb-1">Email</label>
        <input
          type="email"
          id="email"
          v-model="formData.email"
          placeholder="Email"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="password" class="text-gray-600 text-sm block mb-1">Password</label>
        <input
          type="password"
          id="password"
          v-model="formData.password"
          placeholder="Password"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div>
        <label for="password_confirmation" class="text-gray-600 text-sm block mb-1">Confirm Password</label>
        <input
          type="password"
          id="password_confirmation"
          v-model="formData.password_confirmation"
          placeholder="Confirm Password"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <button
        type="submit"
        class="w-full p-3 text-white font-bold rounded-lg bg-gradient-to-r from-[#007AFF] to-[#00D26A] shadow-md hover:opacity-90 transition duration-300"
      >
        Create Account
      </button>

      <p class="text-gray-600 text-xs text-left mt-2">
        Already have an account?
        <a href="/login" class="text-blue-500 font-bold">Login</a>
      </p>
    </form>

  </div>
</template>

<script>
import { useToast } from "vue-toastification";

export default {
  name: "RegisterForm",
  data() {
    return {
      formData: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errors: [],
      logoUrl: "/images/logo.png",
      foodImageUrl: "/images/healthy-food.png",
    };
  },
  setup() {
    const toast = useToast();
    return { toast };
  },
  methods: {
    register() {
      this.errors = [];

      // Form validation client-side
      if (!this.formData.name) this.errors.push("Name is required");
      if (!this.formData.email) this.errors.push("Email is required");
      if (!this.formData.password) this.errors.push("Password is required");
      if (
        this.formData.password &&
        this.formData.password !== this.formData.password_confirmation
      )
        this.errors.push("Password confirmation does not match");

      if (this.errors.length === 0) {
        fetch("/api/register", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify(this.formData),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.errors) {
              this.errors = []; 
              for (const field in data.errors) {
                data.errors[field].forEach((msg) => {
                  this.errors.push(msg);
                });
              }
              this.toast.error(
                "There are some errors in your form. Please check and try again."
              );
            } else {
              this.toast.success(data.message || "Registration successful!");
              setTimeout(() => {
                window.NutriAuth.setToken(data.token);
                window.NutriAuth.applyAuthHeader();
                window.location.href = "/dashboard";
              }, 1500);
            }
          })
          .catch((error) => {
            this.toast.error("An error occurred during registration.");
            console.error("Registration error:", error);
          });
      } else {
        this.toast.error("Please fix the errors in the form.");
      }
    },
  },
};
</script>
