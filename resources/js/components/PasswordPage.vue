<template>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl font-semibold mb-2">Password</h2>
      <p class="text-sm text-gray-500 mb-6">Ganti Password Anda Disini</p>
      
      <form @submit.prevent="updatePassword" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
          <label class="font-semibold text-[#003266] text-md">Password Lama</label>
          <div class="relative sm:col-span-2 w-full">
            <input 
              :type="passwordFields.old.type" 
              v-model="passwordData.old_password"
              class="border border-blue-400 rounded-xl px-4 py-2 w-full pr-10" 
            />
            <i 
              :class="passwordFields.old.icon" 
              class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500"
              @click="togglePassword('old')"
            ></i>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
          <label class="font-semibold text-[#003266] text-md">Password Baru</label>
          <div class="relative sm:col-span-2 w-full">
            <input 
              :type="passwordFields.new.type" 
              v-model="passwordData.new_password"
              class="border border-blue-400 rounded-xl px-4 py-2 w-full pr-10" 
            />
            <i 
              :class="passwordFields.new.icon" 
              class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500"
              @click="togglePassword('new')"
            ></i>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
          <label class="font-semibold text-[#003266] text-md">Konfirmasi Password Baru</label>
          <div class="relative sm:col-span-2 w-full">
            <input 
              :type="passwordFields.confirm.type" 
              v-model="passwordData.new_password_confirmation"
              class="border border-blue-400 rounded-xl px-4 py-2 w-full pr-10" 
            />
            <i 
              :class="passwordFields.confirm.icon" 
              class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500"
              @click="togglePassword('confirm')"
            ></i>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
          <a 
            @click="goBack" 
            class="px-6 py-2 rounded-xl border border-blue-300 text-blue-600 hover:bg-blue-50 transition w-full sm:w-auto cursor-pointer text-center"
          >
            Kembali
          </a>
          <button 
            type="submit"
            class="px-6 py-2 rounded-xl text-white bg-gradient-to-r from-blue-500 to-green-400 hover:opacity-90 transition w-full sm:w-auto"
          >
            Simpan
          </button>
        </div>
      </form>
    </div>

    <!-- Sidebar Kanan -->
    <div>
      <h3 class="text-2xl text-[#003266] font-semibold mb-4">Profile Akun</h3>
      <ul class="space-y-2 text-[#003266]">
        <li><a href="/profil">Info Personal</a></li>
        <li><a href="#" class="font-semibold border-b border-blue-500">Password</a></li>
        <li>
          <button 
            @click="confirmDeletion" 
            class="text-[#003266]"
          >
            Hapus Akun
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from 'vue';
import { useToast } from 'vue-toastification';
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found');
}

export default {
  setup() {
    const toast = useToast();
    
    const passwordData = reactive({
      old_password: '',
      new_password: '',
      new_password_confirmation: ''
    });
    
    const passwordFields = reactive({
      old: {
        type: 'password',
        icon: 'fa-solid fa-eye'
      },
      new: {
        type: 'password',
        icon: 'fa-solid fa-eye'
      },
      confirm: {
        type: 'password',
        icon: 'fa-solid fa-eye'
      }
    });
    
    const togglePassword = (field) => {
      if (passwordFields[field].type === 'password') {
        passwordFields[field].type = 'text';
        passwordFields[field].icon = 'fa-solid fa-eye-slash';
      } else {
        passwordFields[field].type = 'password';
        passwordFields[field].icon = 'fa-solid fa-eye';
      }
    };
    
    const updatePassword = async () => {
      try {
        const formData = new FormData();
        formData.append('old_password', passwordData.old_password);
        formData.append('new_password', passwordData.new_password);
        formData.append('new_password_confirmation', passwordData.new_password_confirmation);
        
        await axios.post('/profil/password', formData);
        toast.success('Password berhasil diperbarui');
        
        // Reset form
        passwordData.old_password = '';
        passwordData.new_password = '';
        passwordData.new_password_confirmation = '';
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          const errorMessages = Object.values(error.response.data.errors).flat();
          errorMessages.forEach(message => toast.error(message));
        } else if (error.response && error.response.data.message) {
          toast.error(error.response.data.message);
        } else {
          toast.error('Error updating password');
        }
        console.error(error);
      }
    };
    
    const goBack = () => {
      window.history.back();
    };
    
    const confirmDeletion = async () => {
      if (confirm('Apakah Anda yakin ingin menghapus akun?')) {
        try {
          const formData = new FormData();
          formData.append('_method', 'DELETE');
          
          await axios.post('/profil/hapus-akun', formData);
          window.location.href = '/';
        } catch (error) {
          toast.error('Error deleting account');
          console.error(error);
        }
      }
    };
    
    return {
      passwordData,
      passwordFields,
      togglePassword,
      updatePassword,
      goBack,
      confirmDeletion
    };
  }
}
</script> 