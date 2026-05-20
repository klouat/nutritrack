import './bootstrap'
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import AsupanPage from './components/AsupanPage.vue'

const app = createApp(AsupanPage)

app.use(Toast)
app.mount('#asupan-app') 