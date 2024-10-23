import { createApp, ref, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';
import { getProductoss } from './comunicationManager.js';
createApp({
    setup() {
        const productos = ref([]);
        const productos2 = ref([]);
        const productosEnCesta = ref([]);
        const cestaActiva = ref(false);
        const finalitzaCompraActiva = ref(false);
        const precioTotal = ref(0); 
        const paginaInicial = ref(true);
        function getProductos() {
            fetch('./JS/ropa.json')
                .then(response => response.json())
                .then(data => {
                    productos.value = data;
                })
                .catch(error => console.error('Error fetching productos:', error));
        }

        function cambiarPantallaPrincipal(){
            if (paginaInicial.value) {
                paginaInicial.value = false;
            }else{
                paginaInicial.value = true;

            }
        }
        async function cargarProductos(){
            try {
                const productos2 = await getProductoss();
                console.log(productos2); // Aquí puedes hacer lo que necesites con los productos
            } catch (error) {
                console.error('No se pudieron cargar los productos:', error);
            }
        }

        function añadirALaCesta(index) {
            const productoSeleccionado = productos.value[index];
            productosEnCesta.value.push(productoSeleccionado);
            cestaActiva.value = true;
            finalitzaCompraActiva.value = true;
            
            precioTotal.value += productoSeleccionado.precio;
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

        onMounted(() => {
            getProductos();
            cargarProductos();
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
            cambiarPantallaPrincipal,
            paginaInicial,
        };
    }
}).mount('#app');
