<template>
  <div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-3xl sm:text-4xl text-center font-bold bg-gradient-to-r from-[#007AFF] to-[#00D26A] bg-clip-text text-transparent mb-6 font-['Poppins']">
      Kelola Pilihan Sehat
    </h1>

    <div class="max-w-xl mx-auto mb-6 flex flex-wrap gap-3 justify-center">
      <!-- Tombol kategori -->
      <button 
        @click="changeCategory(null)" 
        class="px-4 py-2 rounded-xl font-semibold border"
        :class="currentKategori === null ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-800 hover:bg-blue-200'"
      >
        Semua
      </button>

      <button 
        v-for="category in categories" 
        :key="category"
        @click="changeCategory(category)" 
        class="px-4 py-2 rounded-xl font-semibold border"
        :class="currentKategori === category ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-800 hover:bg-blue-200'"
      >
        {{ capitalizeFirstLetter(category) }}
      </button>
    </div>

    <div class="max-w-xl mx-auto mb-6 flex gap-3">
      <a href="/admin/pilihan-sehat/create"
         class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-semibold whitespace-nowrap">
         + Tambah
      </a>
    </div>

    <div class="space-y-6 max-w-4xl mx-auto">
      <div v-if="loading" class="text-center py-10">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
        <p class="mt-2 text-gray-600">Memuat data...</p>
      </div>

      <div v-else-if="items.length === 0" class="text-center text-gray-500 py-10">
        Belum ada data pilihan sehat.
      </div>

      <div v-else v-for="item in items" :key="item.id" 
           class="bg-white p-6 rounded-xl shadow-md flex flex-col md:flex-row gap-4 md:gap-6 items-center">
        <img v-if="item.gambar_path" :src="item.gambar_path" :alt="item.nama"
             class="rounded-lg w-full sm:w-64 h-40 object-cover md:h-28" />
        <div v-else class="rounded-lg w-full sm:w-64 h-40 md:h-28 bg-gray-100 text-gray-400 flex items-center justify-center font-medium">
          Tidak ada gambar
        </div>
        <div class="flex-1 text-center md:text-left">
          <h3 class="font-semibold text-xl sm:text-2xl font-['Poppins']">{{ item.nama }}</h3>
          <p class="text-sm text-gray-500 italic">{{ capitalizeFirstLetter(item.kategori) }}</p>
          <p class="text-base sm:text-lg text-gray-700 mt-2">{{ item.deskripsi }}</p>
        </div>
        <div class="flex flex-col gap-2 text-sm">
          <a :href="`/admin/pilihan-sehat/${item.id}/edit`"
             class="appearance-none bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded-xl text-center font-semibold">
             Edit
          </a>

          <button @click="confirmDelete(item.id)"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-xl w-full">
            Hapus
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  name: 'AdminPilihanSehatIndex',
  data() {
    return {
      items: [],
      categories: ['minuman', 'buah', 'sayur', 'protein', 'karbohidrat'],
      currentKategori: null,
      loading: true,
      toast: useToast()
    };
  },
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    this.currentKategori = urlParams.get('kategori') || null;
    
    this.fetchItems();
  },
  methods: {
    capitalizeFirstLetter(string) {
      if (!string) return '';
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    changeCategory(category) {
      this.currentKategori = category;
      
      if (category) {
        const url = new URL(window.location);
        url.searchParams.set('kategori', category);
        window.history.pushState({}, '', url);
      } else {
        const url = new URL(window.location);
        url.searchParams.delete('kategori');
        window.history.pushState({}, '', url);
      }
      
      this.fetchItems();
    },
    async fetchItems() {
      this.loading = true;
      try {
        const url = '/api/admin/pilihan-sehat';
        const params = this.currentKategori ? { kategori: this.currentKategori } : {};
        
        const response = await axios.get(url, { 
          params,
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        
        this.items = response.data.items || [];
        
        this.items.forEach(item => {
          if (item.gambar_path && !item.gambar_path.startsWith('http')) {
            item.gambar_path = `/${item.gambar_path}`;
          }
        });
        
      } catch (error) {
        console.error('Error fetching data:', error);
        this.toast.error('Gagal memuat data pilihan sehat');
      } finally {
        this.loading = false;
      }
    },
    async confirmDelete(id) {
      if (confirm('Yakin ingin menghapus item ini?')) {
        try {
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          
          if (!csrfToken) {
            this.toast.error('CSRF token tidak ditemukan. Silakan refresh halaman.');
            return;
          }
          
          const response = await axios.delete(`/admin/pilihan-sehat/${id}`, {
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            }
          });
          
          if (response.status === 200 || response.status === 204) {
            this.toast.success('Data berhasil dihapus');
            // Refresh data
            this.fetchItems();
          } else {
            console.error('Error status:', response.status);
            this.toast.error('Gagal menghapus data: ' + (response.data?.message || 'Status tidak valid'));
          }
        } catch (error) {
          console.error('Error deleting item:', error);
          const errorMessage = error.response?.data?.message || error.message || 'Terjadi kesalahan saat menghapus data';
          this.toast.error(`Gagal menghapus data: ${errorMessage}`);
        }
      }
    }
  }
};
</script> 
