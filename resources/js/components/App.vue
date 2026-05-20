<template>
  <nav class="bg-white shadow-md py-4 px-6 sticky top-0 z-40">
    <div class="container mx-auto flex justify-between items-center relative">
      <div class="flex items-center space-x-2">
        <img :src="logo" alt="NutriTrack Logo" class="h-10">
        <h1 class="text-2xl font-bold bg-gradient-to-r from-[#007AFF] to-[#00D26A] bg-clip-text text-transparent">
          NutriTrack
        </h1>
      </div>

      <div class="hidden lg:block lg:absolute lg:left-1/2 lg:top-1/2 lg:-translate-x-1/2 lg:-translate-y-1/2">
        <div class="flex space-x-2 text-white bg-gradient-to-r from-[#007AFF] to-[#00D26A] px-4 py-2 rounded-full">
          <a href="#program" class="px-3 py-1 hover:opacity-80">Program</a>
          <a href="#faq" class="px-3 py-1 hover:opacity-80">FAQ</a>
          <a href="#" class="px-3 py-1 hover:opacity-80">Tentang Kami</a>
          <a href="#testimonials" class="px-3 py-1 hover:opacity-80">Testimoni</a>
        </div>
      </div>
      
      <div class="flex items-center">
        <div class="hidden lg:flex space-x-2">
          <a href="/login" class="px-5 py-2 text-blue-600 border border-blue-400 rounded-full hover:bg-blue-50">Login</a>
          <a href="/register" class="px-5 py-2 text-white bg-gradient-to-r from-[#007AFF] to-[#00D26A] rounded-full hover:opacity-90">Register</a>
        </div>

        <button @click="toggleMobileMenu" class="lg:hidden focus:outline-none z-50 ml-4">
          <svg v-if="!isMobileMenuOpen" class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
          <svg v-else class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  </nav>

  <div v-if="isMobileMenuOpen" @click="toggleMobileMenu" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>

  <div id="menu" 
       class="fixed top-0 right-0 h-full bg-gradient-to-b from-[#007AFF] to-[#00D26A] w-64 shadow-lg transform transition-transform duration-300 ease-in-out z-50 lg:hidden"
       :class="isMobileMenuOpen ? 'translate-x-0' : 'translate-x-full'">
    
    <div class="flex flex-col items-center py-16 space-y-6">
      <a href="#program" @click="handleMenuClick" class="px-4 py-2 text-white text-lg font-semibold">Program</a>
      <a href="#faq" @click="handleMenuClick" class="px-4 py-2 text-white text-lg font-semibold">FAQ</a>
      <a href="#" @click="handleMenuClick" class="px-4 py-2 text-white text-lg font-semibold">Tentang Kami</a>
      <a href="#testimonials" @click="handleMenuClick" class="px-4 py-2 text-white text-lg font-semibold">Testimoni</a>
      <div class="pt-8 w-full px-8 space-y-4">
        <a href="/login" class="block w-full text-center px-5 py-2 text-white border border-white rounded-full hover:bg-white hover:text-blue-600">Login</a>
        <a href="/register" class="block w-full text-center px-5 py-2 text-blue-600 bg-white rounded-full hover:opacity-90">Register</a>
      </div>
    </div>
  </div>

  <main>
    <HomePage />
  </main>
</template>

<script>
import HomePage from './HomePage.vue';

export default {
  name: 'App',
  components: {
    HomePage
  },
  data() {
    return {
      logo: '/images/logo.png',
      isMobileMenuOpen: false
    };
  },
  methods: {
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen;
    },
    handleMenuClick() {
      if (this.isMobileMenuOpen) {
        this.isMobileMenuOpen = false;
      }
    }
  }
}
</script>

<style>
/* MODIFIED: Menambahkan rule ini untuk efek smooth scroll */
html {
  scroll-behavior: smooth;
}

body {
  font-family: 'Poppins', sans-serif;
  background-color: #f5f5f5;
  margin: 0;
  padding: 0;
}
</style>