import { createApp, ref, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
    setup() {
        const productos = ref([]);
        const productosEnCesta = ref([]);
        const cestaActiva = ref(false);

        function getProductos() {
            fetch('/Web/js/ropa.json')
                .then(response => response.json())
                .then(data => {
                    productos.value = data;
                })
                .catch(error => console.error('Error fetching productos:', error));
        }

        function añadirALaCesta(index) {
            const productoSeleccionado = productos.value[index];
            productosEnCesta.value.push(productoSeleccionado);
            cestaActiva.value = true;
        }

        function toggleCesta() {
            cestaActiva.value = !cestaActiva.value;
        }

        onMounted(() => {
            getProductos();
        });

        return {
            productos,
            productosEnCesta,
            añadirALaCesta,
            cestaActiva,
            toggleCesta,
        };
    }
}).mount('#app');
