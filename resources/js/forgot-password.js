import './bootstrap'

// Import Vue & Toast
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

// Import Forgot Password Component
import ForgotPasswordForm from './components/ForgotPasswordForm.vue'

// Mount Forgot Password component
const app = createApp(ForgotPasswordForm)
app.use(Toast)
app.mount('#forgot-password-app') 