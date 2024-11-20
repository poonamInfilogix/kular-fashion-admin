import { createApp } from 'vue';
import GenerateProductBarcodes from './pages/GenerateProductBarcodes.vue';

const app = createApp({});
app.component('generate-product-barcodes', GenerateProductBarcodes);

app.mount('#vue-components');
