import {
  createApp,
  ref,
  onMounted,
  computed,
} from "https://unpkg.com/vue@3/dist/vue.esm-browser.js";
import { getProductoss } from "./comunicationManager.js";

createApp({
  setup() {
    //Las variables para los datos del carrito
    const nombre = ref("");
    const correoElectronico = ref("");
    const direccion = ref("");
    const datosUsuario = ref({ tarjeta: "", expiracion: "", cvv: "" });

    const categorias = ref([
      { nombre: "zapatillas", imagen: "Img/zapatillas.jpeg" },
      { nombre: "sudadera", imagen: "Img/sudadera.jpeg" },
      { nombre: "pantalon", imagen: "Img/pantalon.jpeg" },
      { nombre: "chaqueta", imagen: "Img/chaqueta.jpeg" },
      { nombre: "camiseta", imagen: "Img/camiseta.jpeg" },
      { nombre: "chandal", imagen: "Img/chandal.jpeg" },
      { nombre: "chaleco", imagen: "Img/chaleco.jpeg" },
    ]);

    const productos = ref([]);
    const categoriaFiltrada = ref("");
    const productosEnCesta = ref([]);
    const divActivo = ref("paginaDeInicio");
    const cestaActiva = ref(false);
    const finalitzaCompraActiva = ref(false);
    const precioTotal = ref(0);
    const veureProd = ref();

    function getProductos() {
      fetch("http://localhost:8000/api/getProductos")
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          productos.value = data;
        })
        .catch((error) => console.error("Error fetching productos:", error));
    }

    // funcion para guardar en local storage
    function guardarCarrito() {
      localStorage.setItem(
        "productosEnCesta",
        JSON.stringify(productosEnCesta.value)
      );
    }

    function cargarCarrito() {
      const carritoGuardado = localStorage.getItem("productosEnCesta");
      if (carritoGuardado) {
        productosEnCesta.value = JSON.parse(carritoGuardado);
        actualizarPrecioTotal();
      }
    }

    function eliminarDeLaCesta(index) {
      const productoEliminado = productosEnCesta.value[index];
      productosEnCesta.value.splice(index, 1);

      guardarCarrito();
      actualizarPrecioTotal();

      precioTotal.value -= productoEliminado.precio;

      if (productosEnCesta.value.length === 0) {
        finalitzaCompraActiva.value = false;
      }
    }
    function añadirALaCesta(index) {
      const productoSeleccionado = productos.value[index];
      const productoEnCesta = productosEnCesta.value.find(
        (producto) => producto.id === productoSeleccionado.id
      );

      if (productoEnCesta) {
        productoEnCesta.cantidad++;
      } else {
        const nuevoProducto = { ...productoSeleccionado, cantidad: 1 };
        productosEnCesta.value.push(nuevoProducto);
      }

      guardarCarrito();
      cestaActiva.value = true;
      finalitzaCompraActiva.value = true;
      actualizarPrecioTotal();

      setTimeout(() => {
        cestaActiva.value = false;
      }, 3000);
    }

    const cantidadTotalProductos = computed(() => {
      return calcularCantidadTotalProductos();
    });

    function calcularCantidadTotalProductos() {
      // Utilizo un Set para contar solo productos únicos
      const contados = new Set();
      productosEnCesta.value.forEach((producto) => {
        contados.add(producto.id); // Agrega el ID del producto al Set
      });
      return contados.size; // Me devuelve el tamaño del Set como cantidad total de productos únicos en la cesta
    }

    function restarCantidad(index) {
      const producto = productosEnCesta.value[index];
      if (producto.cantidad > 1) {
        producto.cantidad--;
      }
      actualizarPrecioTotal();
      cestaActiva.value = false;
    }

    function getProducte(index) {
      veureProd.value = index;
      divActivo.value = "producte-item";
    }

    function sumaCantidad(index) {
      const producto = productosEnCesta.value[index];
      producto.cantidad++;
      actualizarPrecioTotal();
    }

    function eliminarDesdeCarrito(index) {
      productosEnCesta.value.splice(index, 1);

      guardarCarrito();
      actualizarPrecioTotal();

      if (productosEnCesta.value.length === 0) {
        finalitzaCompraActiva.value = false;
      }
    }

    function actualizarPrecioTotal() {
      precioTotal.value = productosEnCesta.value.reduce((total, producto) => {
        return total + (producto.preu || 0) * producto.cantidad;
      }, 0);
    }

    // Finalizar compra y pago
    function finalizarCompraDeCarrito() {
      divActivo.value = "finalizarCompraDeCarrito";
      cestaActiva.value = false;
    }

    function procesarCompra() {
        const comandaData = {
          nombre: nombre.value,
          correoElectronico: correoElectronico.value,
          direccion: direccion.value,
          tarjeta: datosUsuario.value.tarjeta,
          expiracion: datosUsuario.value.expiracion,
          cvv: datosUsuario.value.cvv,
          total: precioTotal.value,
        };

        console.log("Datos de la comanda:",comandaData);
      
        // Crear la comanda y obtener su ID
        fetch("http://localhost:8000/api/createComanda", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(comandaData),
      })
      
          .then((response) => response.json())
          .then((comandaResponse) => {
            const comandaId = comandaResponse.id;
            console.log("ID de la comanda:", comandaId);
            
      
            // Luego, registra cada producto con el ID de Comanda
            const promesas = productosEnCesta.value.map((producto) => {
              const comandaArticuloData = {
                idComanda: comandaId,
                idProducto: producto.id,
                talla: producto.talla, 
                color: producto.color,
                quantitat: producto.cantidad,
                preu: producto.preu,
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString(),
              };

              console.log("Datos del articulo en la comanda",comandaArticuloData);
              
              return fetch("http://localhost:8000/api/createComandaArt", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(comandaArticuloData),
            
              });
            });

            return Promise.all(promesas);
          })
          .then(() => {
            alert("Gracias por tu compra");
            productosEnCesta.value = [];
            actualizarPrecioTotal();
            irPantallaInicio();
          })
          .catch((error) => {
            console.error("Error al `rpcesar la compra:", error);
            alert("Error al registrar los productos");
          });
      }
      
      //       // Espera a que todas las promesas se resuelvan
      //       Promise.all(promesas)
      //         .then(() => {
      //           alert("Gracias por tu compra");
      //           productosEnCesta.value = [];
      //           actualizarPrecioTotal();
      //           irPantallaInicio();
      //         })
      //         .catch((error) => {
      //           console.error("Error al registrar productos:", error);
      //           alert("Error al registrar los productos");
      //         });
      //     })
      //     .catch((error) => {
      //       console.error("Error al crear comanda:", error);
      //       alert("Error al crear la comanda");
      //     });
      // }
      

    function volverACarrito() {
      divActivo.value = "carrito";
      cestaActiva.value = false;
    }

    function irABotiga() {
      divActivo.value = "paginaPrincipal";
      cestaActiva.value = false;
    }

    function filtrarPorCategoria(categoria) {
      categoriaFiltrada.value = categoria;
      divActivo.value = "paginaPrincipal";
    }

    function cambiarACarrito() {
      divActivo.value = "carrito";
      cestaActiva.value = false;
    }

    function irPantallaInicio() {
      divActivo.value = "paginaDeInicio";
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
      divActivo.value = "divLogin";
      cestaActiva.value = false;
    }
    function volverALaPaginaPrincipal() {
      divActivo.value = "paginaPrincipal";
      cestaActiva.value = false;
    }

    onMounted(() => {
      getProductos();
      cargarCarrito();
    });

    return {
      nombre,
      correoElectronico,
      direccion,
      datosUsuario,
      productos,
      cantidadTotalProductos,
      productosEnCesta,
      añadirALaCesta,
      eliminarDesdeCarrito,
      restarCantidad,
      sumaCantidad,
      precioTotal,
      actualizarPrecioTotal,
      cestaActiva,
      finalizarCompraDeCarrito,
      procesarCompra,
      volverACarrito,
      botonCesta,
      finalitzaCompraActiva,
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
      veureProd,
    };
  },
}).mount("#app");
