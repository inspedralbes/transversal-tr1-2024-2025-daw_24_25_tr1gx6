import {
    createApp,
    ref,
    onMounted,
    computed,
  } from "https://unpkg.com/vue@3/dist/vue.esm-browser.js";
  import { getProductoss } from "./comunicationManager.js";
  import { checkoutProductos, createComanda } from "./comunicationManager.js";
  
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
      const productos2 = ref([]);
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
            console.log(productos[veureProd]?.color);
            
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
  
      //Añadir los productos a la cesta
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
        // cestaActiva.value = false;
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
        // crea la comanda
        const  comandaData = {
          idUser: 1,
          estat: "Preparando",
          total: precioTotal.value,
        };
        createComanda(comandaData)
          .then((response) => {
            if(response && response.IdComanda){
              const idComanda = response.IdComanda;
  
              const productosParaComanda = productosEnCesta.value.map((producto) => ({
                idProducto: producto.id,
                idComanda: idComanda,
                talla: producto.talla,
                color: producto.color,
                quantitat: producto.cantidad,
                preu: producto.preu,
              }));  
  
              return checkoutProductos(productosParaComanda);
            }else{
              console.log("Error!! No se puede obtener el ID de la comanda.");
            }
          })
          .then((response) => {
            if(response && response.status === "success"){
              console.log("Copra finalizada correctamente");
              
              productosEnCesta.value = [];
              guardarCarrito();
              actualizarPrecioTotal();
             
              finalitzaCompraActiva.value = false;
              divActivo.value = "carrito";
            }else{
              console.log("Error!! al procesar los productos en la comanda");
            }
          })
          .catch((error) => {
            console.error("Error en el proceso de compra:", error);
          });
      }
  
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
      function filtrarPorCategoria(categoria){
        productos2 = [];
        if (categoria != 'todo'){
          if(productos.category.nom == categoria){
            for (let i = 0; i < productos.length; i++) {
              productos2.push(productos[i]);
              
            }
          }
        }
      }
      function filtrarPorMarca(marca){
        productos2 = [];
        if (categoria != 'todo'){
          if(productos.marca.nom == marca){
            for (let i = 0; i < productos.length; i++) {
              productos2.push(productos[i]);
              
            }
          }
        }
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
        filtrarPorMarca,
      };
    },
  }).mount("#app");
  