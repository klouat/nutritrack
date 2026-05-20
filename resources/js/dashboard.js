import './bootstrap'
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import DashboardPage from './components/DashboardPage.vue'

document.addEventListener('DOMContentLoaded', () => {
    const app = createApp(DashboardPage)
    app.use(Toast)
    app.mount('#dashboard-app')
}) 