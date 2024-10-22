import { createApp, ref, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
    setup() {
        const productos = ref([]);
        const productosEnCesta = ref([]);
        const divActivo = ref('paginaPrincipal');
        const cestaActiva = ref(false);
        const finalitzaCompraActiva = ref(false);
        const precioTotal = ref(0);
        function getProductos() {
            fetch('./JS/ropa.json')
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
            finalitzaCompraActiva.value = true;
            
            precioTotal.value += productoSeleccionado.precio;
        }
        function cambiarACarrito(){
            divActivo.value = 'carrito';
        }
        function eliminarDeLaCesta(index) {
            const productoEliminado = productosEnCesta.value[index];
            productosEnCesta.value.splice(index, 1);

            precioTotal.value -= productoEliminado.precio;

            if (productosEnCesta.value.length === 0) {
                finalitzaCompraActiva.value = false;
            }
        }

        function toggleCesta() {
            if(cestaActiva.value){
            cestaActiva.value = false;
            }else{
                cestaActiva.value = true;
            }
        }
        function volverALaPaginaPrincipal(){
            divActivo.value = 'paginaPrincipal';
        }
        onMounted(() => {
            getProductos();
        });

        return {
            productos,
            productosEnCesta,
            añadirALaCesta,
            eliminarDeLaCesta,
            cestaActiva,
            toggleCesta,
            finalitzaCompraActiva,
            precioTotal,
            divActivo,
            cambiarACarrito,
            volverALaPaginaPrincipal
        };
    }
}).mount('#app');
