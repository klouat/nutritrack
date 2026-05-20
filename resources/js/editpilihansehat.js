import './bootstrap'
import { createApp } from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import EditPilihanSehat from './components/EditPilihanSehat.vue';

const app = createApp(EditPilihanSehat)

app.use(Toast)
app.mount('#EditPilihanSehat-app') 