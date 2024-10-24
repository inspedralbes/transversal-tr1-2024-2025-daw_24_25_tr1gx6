import { createApp, ref, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';
import { getProductoss } from './comunicationManager.js';

createApp({
    setup() {

       //Las variables para los datos del carrito
       const nombre = ref('');
       const correoElectronico = ref('');
       const direccion = ref('');
       const datosUsuario = ref({ tarjeta: '', expiracion: '', cvv: '' });

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
        const categoriaFiltrada = ref('');
        const productosEnCesta = ref([]);
        const divActivo = ref('paginaDeInicio');
        const cestaActiva = ref(false);
        const finalitzaCompraActiva = ref(false);
        const precioTotal = ref(0);
        const veureProd = ref()

        function getProductos() {
            fetch('http://localhost:8000/api/getProductos')
                .then(response => response.json())
                .then(data => {
                    console.log(data)
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

            setTimeout(() => {
                
                cestaActiva.value = false;
            }, 2000);
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
        
        // Finalizar compra y pago
        function finalizarCompraDeCarrito() {
            divActivo.value = 'finalizarCompraDeCarrito';  // Cambia el estado a la vista de finalización de compra
            cestaActiva.value = false;  // Oculte el carrito mientras se muestra el formulario de compra
        }
        
        
        function procesarCompra() {
            console.log('Compra procesada', {
                nombre: nombre.value,
                correoElectronico: correoElectronico.value,
                direccion: direccion.value,
                tarjeta: datosUsuario.value.tarjeta,
                expiracion: datosUsuario.value.expiracion,
                cvv: datosUsuario.value.cvv
            });
            alert('Gracias por tu compra');
        }

        function volverACarrito() {
            divActivo.value = 'carrito';
            cestaActiva.value = false;
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

        onMounted(() => {
            getProductos();
        });

        return {
            nombre,
            correoElectronico,
            direccion,
            datosUsuario,
            productos,
            productosEnCesta,
            añadirALaCesta,
            eliminarDesdeCarrito,
            restarCantidad,
            sumaCantidad,
            finalizarCompraDeCarrito,
            actualizarPrecioTotal,
            procesarCompra,
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