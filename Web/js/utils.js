import { createApp, ref, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';
import { getProductoss } from './comunicationManager.js';

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
            fetch('./js/ropa.json')
                .then(response => response.json())
                .then(data => {
                    productos.value = data;
                })
                .catch(error => console.error('Error fetching productos:', error));
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
        function añadirALaCesta(index) {
            const productoSeleccionado = productos.value[index];
            const productoEnCesta = productosEnCesta.value.find(producto => producto.nombre === productoSeleccionado.nombre);

            if (productoEnCesta) {
                productoEnCesta.cantidad++;
            } else {
                const nuevoProducto = { ...productoSeleccionado, cantidad: 1 };
                productosEnCesta.value.push(nuevoProducto);
            }

            cestaActiva.value = true;
            finalitzaCompraActiva.value = true;
            actualizarPrecioTotal();
        }

        function restarCantidad(index) {
            const producto = productosEnCesta.value[index];
            if (producto.cantidad > 1) {
                producto.cantidad--;
            } else {
                eliminarDesdeCarrito(index); 
            }
            actualizarPrecioTotal();
        }

        function sumaCantidad(index) {
            const producto = productosEnCesta.value[index];
            producto.cantidad++;
            actualizarPrecioTotal();
        }

        function eliminarDesdeCarrito(index) {
            productosEnCesta.value.splice(index, 1);
            actualizarPrecioTotal();

            if (productosEnCesta.value.length === 0) {
                finalitzaCompraActiva.value = false;
            }
        }

        function actualizarPrecioTotal() {
            precioTotal.value = productosEnCesta.value.reduce((total, producto) => {
                return total + producto.precio * producto.cantidad;
            }, 0);
        }

        function irABotiga() {
            divActivo.value = 'paginaPrincipal';
            cestaActiva.value = false;
        }

        function filtrarPorCategoria(categoria) {
        }

        function cambiarACarrito() {
            divActivo.value = 'carrito';
            cestaActiva.value = false;
        }

        function irPantallaInicio() {
            divActivo.value = 'paginaDeInicio';
            cestaActiva.value = false;
        }

        function botonCesta() {
            if(cestaActiva.value){
            cestaActiva.value = false;
            }else{
                cestaActiva.value = true;
            }
        }
        function IrLogin(){
            divActivo.value = 'divLogin';
            cestaActiva.value = false;
        }
        function volverALaPaginaPrincipal() {
            divActivo.value = 'paginaPrincipal';
            cestaActiva.value = false;
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
            categorias,
            IrLogin,
            eliminarDeLaCesta
        };
    }
}).mount('#app');