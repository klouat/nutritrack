<template>
  <div class="min-h-screen bg-gray-50 flex items-start">
    <div v-if="form.nama || errors.nama" class="max-w-3xl w-full mx-auto bg-white p-6 rounded-2xl shadow-lg">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Pilihan Sehat</h1>
        <p class="text-gray-500 mt-2">Perbarui detail item di bawah ini.</p>
      </div>

      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
          
          <div class="md:col-span-2 space-y-6">
            <div>
              <label class="block font-medium text-sm text-gray-700 mb-1" for="nama">Nama</label>
              <input
                v-model="form.nama"
                type="text"
                id="nama"
                placeholder="Nama item"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                :class="{ 'border-red-500': errors.nama }"
              />
              <p v-if="errors.nama" class="text-red-500 text-sm mt-1">{{ errors.nama[0] }}</p>
            </div>

            <div>
              <label class="block font-medium text-sm text-gray-700 mb-1" for="deskripsi">Deskripsi</label>
              <textarea
                v-model="form.deskripsi"
                id="deskripsi"
                rows="5"
                placeholder="Deskripsi singkat mengenai item..."
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                :class="{ 'border-red-500': errors.deskripsi }"
              ></textarea>
              <p v-if="errors.deskripsi" class="text-red-500 text-sm mt-1">{{ errors.deskripsi[0] }}</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
               <div>
                <label class="block font-medium text-sm text-gray-700 mb-1" for="urutan">Urutan</label>
                <input
                  v-model.number="form.urutan"
                  type="number"
                  id="urutan"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                  :class="{ 'border-red-500': errors.urutan }"
                />
                <p v-if="errors.urutan" class="text-red-500 text-sm mt-1">{{ errors.urutan[0] }}</p>
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
                <p v-if="errors.aktif" class="text-red-500 text-sm mt-1">{{ errors.aktif[0] }}</p>
              </div>
            </div>

          </div>

          <div class="md:col-span-1">
            <label class="block font-medium text-sm text-gray-700 mb-1">Gambar</label>
            <div class="mt-1">
              <div class="group relative w-full aspect-square rounded-lg border-2 border-gray-300 border-dashed flex items-center justify-center overflow-hidden" :class="{ 'border-red-500': errors.gambar_path }">
                <img v-if="form.preview" :src="form.preview" alt="Preview" class="w-full h-full object-cover">
                <div v-else class="text-center text-gray-400">
                  <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                  <p class="mt-2 text-sm">Tidak ada gambar</p>
                </div>
                
                <label for="gambar_path" class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300 flex items-center justify-center cursor-pointer">
                  <span class="text-white font-bold opacity-0 group-hover:opacity-100 transition-opacity">Ubah Gambar</span>
                </label>
                <input id="gambar_path" name="gambar_path" type="file" class="sr-only" @change="handleFileUpload">
              </div>
            </div>
             <p v-if="errors.gambar_path" class="text-red-500 text-sm mt-1">{{ errors.gambar_path[0] }}</p>
          </div>
        </div>

        <div class="pt-8 flex justify-end items-center gap-4">
          <a href="/admin/pilihan-sehat" class="text-sm font-semibold text-gray-600 hover:text-gray-800">
            Batal
          </a>
          <button
            type="submit"
            class="bg-blue-600 text-white font-bold px-8 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 transform hover:scale-105"
          >
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
    <div v-else class="text-center">
      <p class="text-gray-500">Memuat data...</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  name: 'EditPilihanSehat',
  data() {
    return {
      id: null,
      form: {
        nama: '',
        deskripsi: '',
        gambar_path: null,
        urutan: 1,
        aktif: '1',
        preview: '',
        current_gambar_path: '',
      },
      errors: {},
      toast: useToast(),
    };
  },
  mounted() {
    const urlParts = window.location.pathname.split('/');
    this.id = urlParts[urlParts.indexOf('pilihan-sehat') + 1];
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const res = await axios.get(`/admin/pilihan-sehat/${this.id}/edit`, {
          headers: {
            Accept: 'application/json',
          },
        });
        const data = res.data;
        this.form.nama = data.nama;
        this.form.deskripsi = data.deskripsi;
        this.form.urutan = data.urutan;
        this.form.aktif = String(data.aktif);
        this.form.current_gambar_path = data.gambar_path || '';
        this.form.preview = data.gambar_path
          ? `${window.location.origin}/${data.gambar_path}`
          : '';
      } catch (err) {
        console.error('Error fetching data:', err);
        this.toast.error('Gagal memuat data.');
      }
    },
    handleFileUpload(event) {
      if (event.target.files.length > 0) {
        this.form.gambar_path = event.target.files[0];
        // Create a preview of the new image
        const reader = new FileReader();
        reader.onload = (e) => {
          this.form.preview = e.target.result;
        };
        reader.readAsDataURL(this.form.gambar_path);
      } else {
        this.form.gambar_path = null;
      }
    },
    async submitForm() {
      const formData = new FormData();
      
      for (const key in this.form) {
        if (key === 'preview' || key === 'gambar_path' || key === 'current_gambar_path') continue;
        formData.append(key, this.form[key]);
      }
      
      if (this.form.gambar_path) {
        formData.append('gambar_path', this.form.gambar_path);
      }
      
      formData.append('_method', 'PUT');

      try {
        await axios.post(`/admin/pilihan-sehat/${this.id}`, formData);
        this.toast.success('Data berhasil diperbarui!', {
          position: 'top-right',
        });
        setTimeout(() => {
          window.location.href = '/admin/pilihan-sehat';
        }, 1500);
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        } else {
          console.error('Error submitting form:', error);
          this.toast.error('Terjadi kesalahan saat menyimpan.');
        }
      }
    },
  },
};
</script>
