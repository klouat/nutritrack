import './bootstrap'
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import PilihanSehatPage from './components/PilihanSehatPage.vue'

const app = createApp(PilihanSehatPage)

app.use(Toast)
app.mount('#pilihansehat-app') 