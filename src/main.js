import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import Notifications from '@kyvg/vue3-notification'; // eslint-disable-line

createApp(App).use(store).use(router).use(Notifications).mount('#app'); // eslint-disable-line
