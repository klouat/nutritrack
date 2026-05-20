import './bootstrap'

// Import Vue & Toast
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

// Import Register Component
import RegisterForm from './components/RegisterForm.vue'

// Mount Register component
const app = createApp(RegisterForm)
app.use(Toast)
app.mount('#register-app') 