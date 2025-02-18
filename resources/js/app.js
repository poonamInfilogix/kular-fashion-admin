import { createApp } from 'vue';
import GenerateProductBarcodes from './pages/GenerateProductBarcodes.vue';
import InventoryTransfer from './pages/InventoryTransfer.vue';
import CollectionConditions from './pages/CollectionConditions.vue';

const app = createApp({});
app.component('generate-product-barcodes', GenerateProductBarcodes);
app.component('inventory-tranfer', InventoryTransfer);
app.component('collection-conditions', CollectionConditions);

app.mount('#vue-components');
