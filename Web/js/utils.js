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

        const productos = ref([]);
        const productosEnCesta = ref([]);
        const divActivo = ref('paginaDeInicio');
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
            const productoEnCesta = productosEnCesta.value.find(producto => producto.nombre ===productoSeleccionado.nombre);
            if (productoEnCesta) {
                productoEnCesta.cantidad++;
            } else {
                const numevoProducto = Object.assign({}, productoSeleccionado, { cantidad: 1});
                productosEnCesta.value.push(numevoProducto);
            }

            cestaActiva.value = true;
            finalitzaCompraActiva.value = true;
            actualizarPrecioTotal();
            
            precioTotal.value += productoSeleccionado.precio;
        }

        // Funcion para Carrito
        function restarCantidad(index) {
            const producto = productosEnCesta.value[index];

            if(producto.cantidad > 1){
                producto.cantidad--;
                actualizarPrecioTotal();
            }
        }

        function sumaCantidad(index) {
            const producto = productosEnCesta.value[index];
            producto.cantidad++;
            actualizarPrecioTotal();
        }

        function eliminarDesdeCarrito(index) {
            productosEnCesta.value.splice(index,1);
            actualizarPrecioTotal();

            if(productoEnCesta.value.length === 0){
                finalitzaCompraActiva.value = false;
            }
        }
        
        function actualizarPrecioTotal() {
            precioTotal.value = 0;
      
            for (let i = 0; i < productosEnCesta.value.length; i++) {
              precioTotal.value += productosEnCesta.value[i].precio * productosEnCesta.value[i].cantidad;
            }
          }
        
        function irABotiga(){
            divActivo.value = 'paginaPrincipal';
        }
        function filtrarPorCategoria(categoria) {
            categoriaFiltrada.value = categoria;
        }
        function cambiarACarrito(){
            divActivo.value = 'carrito';
        }
        function irPantallaInicio(){
            divActivo.value = 'paginaDeInicio';
        }
        function eliminarDeLaCesta(index) {
            const productoEliminado = productosEnCesta.value[index];
            productosEnCesta.value.splice(index, 1);

            actualizarPrecioTotal();

            precioTotal.value -= productoEliminado.precio;

            if (productosEnCesta.value.length === 0) {
                finalitzaCompraActiva.value = false;
            }
        }

        function botonCesta() {
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
            eliminarDesdeCarrito,
            restarCantidad,
            sumaCantidad,
            actualizarPrecioTotal,
            eliminarDeLaCesta,
            cestaActiva,
            botonCesta,
            finalitzaCompraActiva,
            precioTotal,
            divActivo,
            cambiarACarrito,
            volverALaPaginaPrincipal,
            irPantallaInicio,
            irABotiga,
            filtrarPorCategoria,
            categorias
        };
    }
}).mount('#app');
