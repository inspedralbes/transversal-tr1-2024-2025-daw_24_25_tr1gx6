import { createApp, ref, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

createApp({
    setup() {
        const categorias = ref([
            { nombre: "zapatillas", imagen: "Img/zapatillas.jpeg" },
            { nombre: "sudadera", imagen: "Img/sudadera.jpeg" },
            { nombre: "pantalon", imagen: "Img/pantalon.jpeg" },
            { nombre: "chaqueta", imagen: "Img/chaqueta.jpeg" },
            { nombre: "camiseta", imagen: "Img/camiseta.jpeg" },
            { nombre: "chandal", imagen: "Img/chandal.jpeg" },
            { nombre: "chaleco", imagen: "Img/chaleco.jpeg" }
        ]);
        
        let categoriaFiltrada = ref(null); // Cambiado a ref para ser reactivo        
        const productos = ref([]);
        const productosEnCesta = ref([]);
        const cestaActiva = ref(false);
        const finalitzaCompraActiva = ref(false);
        const precioTotal = ref(0); 
        const divActivo = ref('paginaPrincipal');
        const paginaInicial = ref(true);

        function getProductos() {
            fetch('./js/ropa.json')
                .then(response => response.json())
                .then(data => {
                    productos.value = data;
                })
                .catch(error => console.error('Error fetching productos:', error));
        }

        function cambiarPantallaPrincipal(){
            paginaInicial.value = !paginaInicial.value;
        }

        function filtrarPorCategoria(categoria) {
            categoriaFiltrada.value = categoria;
        }

        function cambiarACarrito(){
            divActivo.value = 'carrito';
        }

        function volverALaPaginaPrincipal(){
            divActivo.value = 'paginaPrincipal';
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
            cestaActiva.value = !cestaActiva.value; // Simplificado
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
            cambiarPantallaPrincipal,
            paginaInicial,
            categorias, // Asegúrate de incluir categorías para usarlas en tu plantilla
            categoriaFiltrada,
            filtrarPorCategoria // Para poder acceder en la plantilla
        };
    }
}).mount('#app');
