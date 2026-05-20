<template>
  <div class="p-10 justify-center">
    <div 
      class="rounded-2xl shadow-lg" 
      style="background-color: #F1F1F1; padding: 3rem; box-shadow: inset 0 3px 6px rgba(0,0,0,0.1), 0 6px 14px rgba(0,0,0,0.1);"
    >
      <div class="flex flex-col items-center space-y-10">
        <!-- Baris 1: 3 kotak -->
        <div class="flex space-x-10">
          <div 
            class="text-center shadow-md rounded-xl p-6 w-50" 
            style="background-color: #FFB4B4;"
          >
            <h2 class="text-2xl font-bold mb-6">Buah <br>Buahan</h2>
            <router-link 
              to="/sehat/buah" 
              v-if="false"
              class="bg-white text-black text-base px-6 py-2 rounded-full shadow inline-block"
            >
              PILIH
            </router-link>
            <a 
              :href="'/sehat/buah'" 
              class="bg-white text-black text-base px-6 py-2 rounded-full shadow inline-block"
            >
              PILIH
            </a>
          </div>

          <div 
            class="bg-green-100 text-center shadow-md rounded-xl p-6 w-50 ml-3" 
            style="background-color: #DCFCE7;"
          >
            <h2 class="text-2xl font-bold mb-6"><br>Sayur</h2>
            <a 
              :href="'/sehat/sayur'" 
              class="bg-white text-black text-base px-6 py-2 rounded-full shadow inline-block"
            >
              PILIH
            </a>
          </div>

          <div 
            class="bg-yellow-200 text-center shadow-md rounded-xl p-6 w-50 ml-3" 
            style="background-color: #FFFC9F;"
          >
            <h2 class="text-2xl font-bold mb-6">Protein <br> Sehat</h2>
            <a 
              :href="'/sehat/protein'" 
              class="bg-white text-black text-base px-6 py-2 rounded-full shadow inline-block"
            >
              PILIH
            </a>
          </div>
        </div>

        <br>
        <!-- Baris 2: 2 kotak di tengah -->
        <div class="flex space-x-10">
          <div 
            class="bg-blue-200 text-center shadow-md rounded-xl p-6 w-50 ml-3" 
            style="background-color: #CAD6FF;"
          >
            <h2 class="text-2xl font-bold mb-6">Minuman <br> Sehat</h2>
            <a 
              :href="'/sehat/minuman'" 
              class="bg-white text-black text-base px-6 py-2 rounded-full shadow inline-block"
            >
              PILIH
            </a>
          </div>

          <div 
            class="bg-orange-200 text-center shadow-md rounded-xl p-6 w-50 ml-3" 
            style="background-color: #FFC48D;"
          >
            <h2 class="text-2xl font-bold mb-6">Karbohidrat <br> Kompleks</h2>
            <a 
              :href="'/sehat/karbohidrat'" 
              class="bg-white text-black text-base px-6 py-2 rounded-full shadow inline-block"
            >
              PILIH
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PilihanSehatPage',
  setup() {
    return {}
  }
}
</script> 