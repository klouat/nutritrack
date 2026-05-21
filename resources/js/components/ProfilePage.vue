<template>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">
      <!-- Form Section -->
      <div class="md:col-span-2 bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold mb-2">Info Personal</h2>
        <p class="text-sm text-gray-500 mb-6">Kamu bisa perbarui data pribadi kamu di sini</p>

        <div class="mb-6 flex items-center gap-4">
          <img
            v-if="user.foto_profil_url"
            :src="user.foto_profil_url"
            alt="Foto Profil"
            class="h-20 w-20 rounded-full object-cover"
          />
          <div
            v-else
            class="flex h-20 w-20 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700"
          >
            Foto
          </div>
          <div class="flex-1">
            <label class="mb-2 block font-semibold text-[#003266]">Upload Foto Profil</label>
            <input type="file" accept="image/*" @change="onPhotoChange" />
          </div>
        </div>

        <form @submit.prevent="updateProfile" class="space-y-4">
          <div
            v-for="(field, key) in fields"
            :key="key"
            class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4"
          >
            <label :for="key" class="font-semibold text-[#003266] text-md">
              {{ field.label }}
            </label>
            <input
              :type="field.type"
              :id="key"
              v-model="user[key]"
              :placeholder="field.label"
              class="sm:col-span-2 border border-blue-400 rounded-xl px-4 py-2 w-full"
            />
          </div>

          <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
            <a
              @click="goBack"
              class="px-6 py-2 rounded-xl border border-blue-300 text-blue-600 hover:bg-blue-50 transition w-full sm:w-auto text-center cursor-pointer"
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

      <!-- Sidebar Section -->
      <div>
        <h3 class="text-2xl text-[#003266] font-semibold mb-4">Profile Akun</h3>
        <ul class="space-y-2 text-[#003266]">
          <li>
            <a href="#" class="font-semibold border-b border-blue-500">Info Personal</a>
          </li>
          <li>
            <a :href="passwordUpdateRoute">Password</a>
          </li>
          <li>
            <button @click="confirmDeletion" class="text-[#003266]">Hapus Akun</button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';


axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const csrfToken = document.head.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}

export default {
  setup() {
    const user = ref({
      name: '',
      email: '',
      nomor_telepon: '',
      umur: '',
      pekerjaan: '',
      riwayat_kesehatan: '',
      alergi: '',
      foto_profil: null,
      foto_profil_url: null
    });

    const fields = {
      name: { label: 'Nama', type: 'text' },
      email: { label: 'Email Address', type: 'email' },
      nomor_telepon: { label: 'No. Telp', type: 'text' },
      umur: { label: 'Umur', type: 'number' },
      pekerjaan: { label: 'Pekerjaan', type: 'text' },
      riwayat_kesehatan: { label: 'Riwayat Kesehatan', type: 'text' },
      alergi: { label: 'Alergi', type: 'text' }
    };

    const toast = useToast();
    const passwordUpdateRoute = ref('');
    const deleteAccountRoute = ref('');

    onMounted(async () => {
      try {
        const response = await axios.get('/api/profile');
        user.value = {
          ...user.value,
          ...response.data,
          foto_profil: null,
          foto_profil_url: response.data.foto_profil
        };
        passwordUpdateRoute.value = response.data.routes?.password_update || '/profil/password';
        deleteAccountRoute.value = response.data.routes?.delete_account || '/profil/hapus-akun';
      } catch (error) {
        toast.error('Gagal memuat data profil');
        console.error(error);
      }
    });

    const updateProfile = async () => {
      try {
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name', user.value.name || '');
        formData.append('email', user.value.email || '');
        formData.append('nomor_telepon', user.value.nomor_telepon || '');
        formData.append('umur', user.value.umur || '');
        formData.append('pekerjaan', user.value.pekerjaan || '');
        formData.append('riwayat_kesehatan', user.value.riwayat_kesehatan || '');
        formData.append('alergi', user.value.alergi || '');

        if (user.value.foto_profil) {
          formData.append('foto_profil', user.value.foto_profil);
        }

        const response = await axios.post('/api/profile', formData);
        user.value = {
          ...user.value,
          ...response.data.user,
          foto_profil: null,
          foto_profil_url: response.data.user.foto_profil ? `/${response.data.user.foto_profil}` : user.value.foto_profil_url
        };
        toast.success('Profil berhasil diperbarui');
      } catch (error) {
        if (error.response?.data?.errors) {
          Object.values(error.response.data.errors).flat().forEach(msg => toast.error(msg));
        } else {
          toast.error('Gagal memperbarui profil');
        }
        console.error(error);
      }
    };

    const onPhotoChange = (event) => {
      const [file] = event.target.files || [];
      user.value.foto_profil = file || null;

      if (file) {
        user.value.foto_profil_url = URL.createObjectURL(file);
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

          await axios.post(deleteAccountRoute.value, formData);
          window.location.href = '/';
        } catch (error) {
          toast.error('Gagal menghapus akun');
          console.error(error);
        }
      }
    };

    return {
      user,
      fields,
      passwordUpdateRoute,
      updateProfile,
      onPhotoChange,
      goBack,
      confirmDeletion
    };
  }
};
</script>


