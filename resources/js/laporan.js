import './bootstrap'
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import LaporanPage from './components/LaporanPage.vue'

const app = createApp(LaporanPage)

app.use(Toast)
app.mount('#laporan-app') 