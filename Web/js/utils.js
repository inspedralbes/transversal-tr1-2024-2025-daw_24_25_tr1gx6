import { createApp, ref, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

        createApp({
            setup() {
                const productos = ref([]);
                const productoEnCesta = ref ([]);
                const cestaActiva = ref(false);
                function getProductos() {
                    fetch('/Web/js/ropa.json')
                        .then(response => response.json())
                        .then(data => {
                            productos.value = data; 
                        })
                        .catch(error => console.error('Error fetching productos:', error));
                }
                // function añadirALaCesta(index){
                //     productoEnCesta.push(productos[index].value);
                //     cestaActiva.value = true;
                // }
                onMounted(() => {
                    getProductos(); 
                });

                return {
                    productos,
                    // añadirALaCesta
                };
            }
        }).mount('#app');