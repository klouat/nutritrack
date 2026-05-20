import './bootstrap'
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()


import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'


import App from './components/App.vue'


const app = createApp(App)

app.use(Toast)
app.mount('#app')
