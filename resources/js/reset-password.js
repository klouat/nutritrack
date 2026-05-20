import './bootstrap'

// Import Vue & Toast
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

// Import Reset Password Component
import ResetPasswordForm from './components/ResetPasswordForm.vue'

// Mount Reset Password component
const app = createApp(ResetPasswordForm)
app.use(Toast)
app.mount('#reset-password-app') 