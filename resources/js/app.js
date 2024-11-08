import { createApp } from 'vue';
import SizeScale from './components/product/inputs/SizeScale.vue';

const app = createApp({});
app.component('size-scale-select', SizeScale);

app.mount('#vue-components');
