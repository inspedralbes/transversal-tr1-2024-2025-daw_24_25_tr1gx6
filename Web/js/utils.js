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
        const productosMostrados = ref([]);
        const categoriasMostradas = ref([]);
        const productoIndex = ref(0);
        const categoriaIndex = ref(0);
        const categoriaFiltrada = ref('');
        const productosEnCesta = ref([]);
        const divActivo = ref('paginaDeInicio');
        const cestaActiva = ref(false);
        const finalitzaCompraActiva = ref(false);
        const precioTotal = ref(0);
        const veureProd = ref()
        async function getProductos() {
            try {
                productos.value = await getProductoss();
                console.log('Productos obtenidos:', productos.value);
            } catch (error) {
                console.error('Error al obtener productos:', error);
            }
        }

        function inicializarMostrados() {
            const productosOrdenados = Array.from(productos.value);
            productosOrdenados.sort((a, b) => b.valoracion - a.valoracion);
            productosMostrados.value = productosOrdenados.slice(0, 10);
        
            actualizarProductosMostrados();
            actualizarCategoriasMostradas();
        }
        

        function actualizarProductosMostrados() {
            if (productosMostrados.value.length > 0) { 
                productosMostrados.value = productosMostrados.value
                    .slice(productoIndex.value, productoIndex.value + 4);
                productoIndex.value = (productoIndex.value + 4) % productosMostrados.value.length;
            }
        }        

        function actualizarCategoriasMostradas() {
            if (categorias.value.length > 0) {
                categoriasMostradas.value = categorias.value.slice(
                    categoriaIndex.value,
                    categoriaIndex.value + 3
                );
                categoriaIndex.value = (categoriaIndex.value + 3) % categorias.value.length;
            }
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
            const productoEnCesta = productosEnCesta.value.find(producto => producto.nom === productoSeleccionado.nom);

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
            cestaActiva.value = false;
        }

        function getProducte(index) {
            veureProd.value = index;
            divActivo.value = 'producte-item';
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
                return total + producto.preu * producto.cantidad;
            }, 0);
        }

        function irABotiga() {
            divActivo.value = 'paginaPrincipal';
            cestaActiva.value = false;
        }

        function filtrarPorCategoria(categoria) {
            categoriaFiltrada.value = categoria;
            divActivo.value = 'paginaPrincipal';
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
            if (cestaActiva.value) {
                cestaActiva.value = false;
            } else {
                cestaActiva.value = true;
            }
        }
        function IrLogin() {
            divActivo.value = 'divLogin';
            cestaActiva.value = false;
        }
        function volverALaPaginaPrincipal() {
            divActivo.value = 'paginaPrincipal';
            cestaActiva.value = false;
        }

        onMounted(async () => {
            await getProductos();
            inicializarMostrados(); 
            actualizarProductosMostrados();
            actualizarCategoriasMostradas();
            setInterval(actualizarProductosMostrados, 3000);
            setInterval(actualizarCategoriasMostradas, 3000);
        });

        return {
            productos,
            productosMostrados,
            categoriasMostradas,
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
            categoriaFiltrada,
            IrLogin,
            eliminarDeLaCesta,
            getProducte,
            veureProd
        };
    }
}).mount('#app');