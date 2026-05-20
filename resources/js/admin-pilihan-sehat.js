import { createApp } from 'vue';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import AdminPilihanSehatIndex from './components/AdminPilihanSehatIndex.vue';

const app = createApp(AdminPilihanSehatIndex);
app.use(Toast);
app.mount('#admin-pilihan-sehat-app'); 