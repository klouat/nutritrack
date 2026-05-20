<template>
  <div class="max-w-3xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Buat Laporan</h2>

    <form @submit.prevent="submitLaporan" class="space-y-6">
      <div class="mb-4">
        <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul</label>
        <input 
          type="text" 
          v-model="laporan.judul"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" 
          placeholder="Masukkan judul laporan" 
          required
        >
        <div v-if="errors.judul" class="text-red-500 text-sm mt-1">{{ errors.judul[0] }}</div>
      </div>

      <div class="mb-6">
        <label for="isi_laporan" class="block text-gray-700 font-semibold mb-2">Isi Laporan</label>
        <textarea 
          v-model="laporan.isi_laporan"
          rows="10"
          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
          placeholder="Tulis laporan lengkap di sini..." 
          required
        ></textarea>
        <div v-if="errors.isi_laporan" class="text-red-500 text-sm mt-1">{{ errors.isi_laporan[0] }}</div>
      </div>

      <button 
        type="submit" 
        class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300"
        :disabled="isSubmitting"
      >
        {{ isSubmitting ? 'Mengirim...' : 'Kirim' }}
      </button>
    </form>
  </div>
</template>

<script>
import { reactive, ref } from 'vue';
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
    const errors = reactive({});
    const isSubmitting = ref(false);
    
    const laporan = reactive({
      judul: '',
      isi_laporan: ''
    });
    
    const submitLaporan = async () => {
      isSubmitting.value = true;
      errors.judul = null;
      errors.isi_laporan = null;
      
      try {
        const formData = new FormData();
        formData.append('judul', laporan.judul);
        formData.append('isi_laporan', laporan.isi_laporan);
        
        await axios.post('/laporan', formData);
        toast.success('Laporan berhasil dibuat');
        
        // Reset form
        laporan.judul = '';
        laporan.isi_laporan = '';
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          Object.assign(errors, error.response.data.errors);
          
          const firstError = Object.values(error.response.data.errors)[0][0];
          toast.error(firstError);
        } else {
          toast.error('Terjadi kesalahan saat membuat laporan');
        }
        console.error(error);
      } finally {
        isSubmitting.value = false;
      }
    };
    
    return {
      laporan,
      errors,
      isSubmitting,
      submitLaporan
    };
  }
}
</script> 