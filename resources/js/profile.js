import './bootstrap'
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import ProfilePage from './components/ProfilePage.vue'

const app = createApp(ProfilePage)

app.use(Toast)
app.mount('#profile-app') 