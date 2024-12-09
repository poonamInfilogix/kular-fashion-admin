import { createApp } from 'vue';
import GenerateProductBarcodes from './pages/GenerateProductBarcodes.vue';
import InventoryTransfer from './pages/InventoryTransfer.vue';

const app = createApp({});
app.component('generate-product-barcodes', GenerateProductBarcodes);
app.component('inventory-tranfer', InventoryTransfer);

app.mount('#vue-components');
