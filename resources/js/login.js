import './bootstrap'


import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'


import LoginForm from './components/LoginForm.vue'


const app = createApp(LoginForm)
app.use(Toast)
app.mount('#login-app') 