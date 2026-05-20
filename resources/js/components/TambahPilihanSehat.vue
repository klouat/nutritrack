<template>
  <div class="min-h-screen bg-gray-50 flex items-start">
    <div class="max-w-2xl w-full mx-auto bg-white p-6 rounded-2xl shadow-lg">
      <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Pilihan Sehat</h1>
        <p class="text-gray-500 mt-2">Isi detail di bawah ini untuk menambahkan item baru.</p>
      </div>

      <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-5">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
          <div>
            <label class="block font-medium text-sm text-gray-700 mb-1" for="judul">Judul</label>
            <input
              v-model="form.judul"
              type="text"
              id="judul"
              placeholder="Contoh: Anggur"
              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
              :class="{ 'border-red-500': errors.judul }"
            />
            <p v-if="errors.judul" class="text-red-500 text-sm mt-1">{{ errors.judul }}</p>
          </div>
          
          <div>
            <label class="block font-medium text-sm text-gray-700 mb-1" for="nama">Nama</label>
            <input
              v-model="form.nama"
              type="text"
              id="nama"
              placeholder="Contoh: Anggur Merah Globe"
              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
              :class="{ 'border-red-500': errors.nama }"
            />
            <p v-if="errors.nama" class="text-red-500 text-sm mt-1">{{ errors.nama }}</p>
          </div>

          <div>
            <label class="block font-medium text-sm text-gray-700 mb-1" for="kategori">Kategori</label>
            <select
              v-model="form.kategori"
              id="kategori"
              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
              :class="{ 'border-red-500': errors.kategori }"
            >
              <option disabled value="">-- Pilih Kategori --</option>
              <option v-for="item in kategoriOptions" :key="item" :value="item">{{ item }}</option>
            </select>
            <p v-if="errors.kategori" class="text-red-500 text-sm mt-1">{{ errors.kategori }}</p>
          </div>
          
          <div>
            <label class="block font-medium text-sm text-gray-700 mb-1" for="gambar_path">Gambar (Opsional)</label>
            <div class="relative flex items-center justify-center w-full h-[6.5rem] border-2 border-gray-300 border-dashed rounded-lg" :class="{ 'border-red-500': errors.gambar_path }">
              <div v-if="!imagePreviewUrl" class="text-center">
                <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                <span class="mt-1 block text-sm font-medium text-blue-600">Pilih file</span>
              </div>
              <img v-if="imagePreviewUrl" :src="imagePreviewUrl" alt="Image Preview" class="absolute inset-0 w-full h-full object-cover rounded-lg" />
              <input id="gambar_path" name="gambar_path" type="file" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" @change="handleFileUpload">
            </div>
            <p v-if="errors.gambar_path" class="text-red-500 text-sm mt-1">{{ errors.gambar_path }}</p>
          </div>
          
          <div class="md:col-span-2">
            <label class="block font-medium text-sm text-gray-700 mb-1" for="deskripsi">Deskripsi</label>
            <textarea
              v-model="form.deskripsi"
              id="deskripsi"
              rows="3"
              placeholder="Deskripsi singkat mengenai item..."
              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
              :class="{ 'border-red-500': errors.deskripsi }"
            ></textarea>
            <p v-if="errors.deskripsi" class="text-red-500 text-sm mt-1">{{ errors.deskripsi }}</p>
          </div>

          <div>
            <label class="block font-medium text-sm text-gray-700 mb-1" for="urutan">Urutan</label>
            <input
              v-model.number="form.urutan"
              type="number"
              id="urutan"
              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
              :class="{ 'border-red-500': errors.urutan }"
            />
            <p v-if="errors.urutan" class="text-red-500 text-sm mt-1">{{ errors.urutan }}</p>
          </div>
          
          <div>
            <label class="block font-medium text-sm text-gray-700 mb-1" for="aktif">Status</label>
            <select
              v-model="form.aktif"
              id="aktif"
              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
              :class="{ 'border-red-500': errors.aktif }"
            >
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
            <p v-if="errors.aktif" class="text-red-500 text-sm mt-1">{{ errors.aktif }}</p>
          </div>
        </div>

        <div class="text-center pt-4">
          <button
            type="submit"
            class="w-full sm:w-auto bg-blue-600 text-white font-bold px-10 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 transform hover:scale-105"
          >
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { useToast } from 'vue-toastification';
import axios from 'axios';

export default {
  name: 'TambahPilihanSehat',
  data() {
    return {
      form: {
        judul: '',
        kategori: '',
        gambar_path: null,
        nama: '',
        deskripsi: '',
        urutan: 1,
        aktif: '1',
      },
      errors: {},
      kategoriOptions: ['Minuman', 'Buah', 'Sayur', 'Protein', 'Karbohidrat'],
      toast: useToast(),
      imagePreviewUrl: null, 
    };
  },
  methods: {
    handleFileUpload(event) {
      const file = event.target.files[0];
      this.form.gambar_path = file;

      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreviewUrl = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.imagePreviewUrl = null;
      }
    },
    async submitForm() {
      const formData = new FormData();
      for (const key in this.form) {
        if (key === 'gambar_path') continue;
        formData.append(key, this.form[key]);
      }

      if (this.form.gambar_path) {
        formData.append('gambar_path', this.form.gambar_path);
      }

      try {
        await axios.post('/api/admin/pilihan-sehat', formData, {
          headers: {
            'Accept': 'application/json'
          }
        });

        this.toast.success('Data berhasil ditambahkan!', {
          position: 'top-right',
          timeout: 3000,
        });

        setTimeout(() => {
          window.location.href = '/admin/pilihan-sehat';
        }, 1500);
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
          this.toast.error('Gagal validasi. Periksa kembali isian form Anda.', {
            position: 'top-right',
            timeout: 3000,
          });
        } else {
          this.toast.error('Terjadi kesalahan saat menyimpan data.', {
            position: 'top-right',
            timeout: 3000,
          });
        }
      }
    },
  },
};
</script>

<style scoped>
</style>
