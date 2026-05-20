import './bootstrap'
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import TambahPilihanSehat from './components/TambahPilihanSehat.vue';

const app = createApp(TambahPilihanSehat)

app.use(Toast)
app.mount('#TambahPilihanSehat-app') 