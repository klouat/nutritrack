import './bootstrap'
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import PasswordPage from './components/PasswordPage.vue'

const app = createApp(PasswordPage)

app.use(Toast)
app.mount('#password-app') 