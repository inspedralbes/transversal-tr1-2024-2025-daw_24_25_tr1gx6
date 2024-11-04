import {
  createApp,
  ref,
  onMounted,
  computed,
  reactive,
} from "https://unpkg.com/vue@3/dist/vue.esm-browser.js";
import {
  getProductoss,
  productobyID,
  checkoutProductos,
  createComanda,
} from "./comunicationManager.js";

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
    let productos2 = ref([]);
    const stockProdctuId = ref([]);
    const categoriaFiltrada = ref("");
    const productosEnCesta = ref([]);
    const divActivo = ref("paginaDeInicio");
    const cestaActiva = ref(false);
    const finalitzaCompraActiva = ref(false);
    const precioTotal = ref(0);
    const veureProd = ref();
    const selectedCombinacion = ref("");
    const email = ref("");
    const password = ref("");

    function getProductos() {
      fetch("http://localhost:8000/api/getProductos")
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          if (Array.isArray(data) && data.length > 0) {
            productos.value = data;
            productos2.value = data;
            console.log(productos.value); // Verificar que cada producto tenga category y marca
          } else {
            console.error(
              "No se encontraron productos o la respuesta no es válida."
            );
          }
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

      // Log para verificar la combinación seleccionada
      //console.log("Selected Combination:", selectedCombinacion.value);
      // Obtener la talla seleccionada
    const tallaSeleccionada = stockProdctuId.value.find(combinacion => combinacion.id === selectedCombinacion.value);
    
    // Log para verificar la combinación seleccionada
    console.log("Selected Combination:", selectedCombinacion.value);
    console.log("Talla Seleccionada:", tallaSeleccionada); // Para verificar si se obtuvo correctamente

      // Crear un nuevo objeto del producto
      const nuevoProducto = {
        id: productoSeleccionado.id,
        nom: productoSeleccionado.nom,
        img: productoSeleccionado.img,
        preu: productoSeleccionado.preu,
        // valoracion: productoSeleccionado.valoracion,
        stock: productoSeleccionado.stock,
        category: productoSeleccionado.category,
        marca: productoSeleccionado.marca,
        desc: productoSeleccionado.desc,
        cantidad: 1,
        talla: tallaSeleccionada ? (tallaSeleccionada.TallaCamisa || tallaSeleccionada.TallaZapato) : 'Sin talla', // Elegir la talla disponible        color: selectedCombinacion.value.split(" ")[0],
        color: tallaSeleccionada ? tallaSeleccionada.Color : 'Sin color', // Capturar el color
        idStock: selectedCombinacion.value,
      };

      console.log("Nuevo producto:", nuevoProducto);
      

      const productoEnCesta = productosEnCesta.value.find(
        (producto) =>
          producto.id === productoSeleccionado.id &&
          producto.color === nuevoProducto.color &&
          producto.talla === nuevoProducto.talla
      );

      if (productoEnCesta) {
        productoEnCesta.cantidad++;
      } else {
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
        contados.add(producto.id);
      });
      return contados.size;
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
      if (index >= 0 && index < productos.value.length) {
        veureProd.value = index;
        divActivo.value = "producte-item";
        const idProducto = productos.value[index].id;

        productobyID({ idProducto })
          .then((detallesProducto) => {
            console.log("Antes del if:", detallesProducto);
            stockProdctuId.value = detallesProducto;
            if (detallesProducto && Array.isArray(detallesProducto)) {
              console.log("index:", index);

              productos.value[index].category = productos.value[index].category || { nom: "" };
              productos.value[index].marca = productos.value[index].marca || {nom: "",};

              console.log("Detalles del producto con idStock:",productos.value[index]);
            } else {
              console.error("No se encontraron detalles para el producto.");
            }
          })
          .catch((error) => {
            console.error("Error al obtener detalles del producto:", error);
          });
      } else {
        console.log("El índice del producto no es válido", index);
      }
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
        idUser: 1,
        estat: "Preparando",
        total: precioTotal.value,
      };

      createComanda(comandaData)
        .then((response) => {
          if (response && response.IdComanda) {
            const idComanda = response.IdComanda;

            // Mostrar productos en cesta en la consola
            console.log("Productos en la cesta:", productosEnCesta.value);

            // Crear JSON para enviar al servidor sin idStock
            const productosParaComanda = productosEnCesta.value.map(
              (producto) => ({
                idProducto: producto.id,
                idComanda: idComanda,
                idStock: producto.idStock,
                talla: producto.talla,
                color: producto.color,
                quantitat: producto.cantidad,
                preu: producto.preu,
              })
            );

            console.log(
              "JSON a enviar al servidor:",
              JSON.stringify(productosParaComanda, null, 2)
            );

            return checkoutProductos(productosParaComanda);
          } else {
            console.log("Error!! No se puede obtener el ID de la comanda.");
          }
        })
        .then((response) => {
          if (response && response.status === "success") {
            console.log("Compra finalizada correctamente");
            productosEnCesta.value = [];
            guardarCarrito();
            actualizarPrecioTotal();
            finalitzaCompraActiva.value = false;
            divActivo.value = "carrito";
          } else {
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

    onMounted(() => {
      getProductos();
      cargarCarrito();
    });

    function filtrarPorCategoria(){
      productos2.value = [];
      
      let categoria = document.querySelector(".categoria").value;
      console.log("te has metido en el filtro de categorias");
      console.log(productos2.value)
      if(categoria != "todo"){
        for (let i = 0; i < productos.value.length; i++) {
          console.log("hola")
          if(productos.value[i].category.nom === categoria){
            productos2.value.push(productos.value[i]);
            }
          }
      }else{
        productos2.value = productos.value;
      }
    }
    function filtrarPorMarca(){
      productos2 = [];
      if(productos.marca.nom == marca){
        for (let i = 0; i < productos.length; i++) {
          productos2.push(productos[i]);
            
        }
      }
    }
    async function submitLogin() {
      try {
        await fetch("http://localhost:8000/api/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: email.value,
            password: password.value,
          }),
        });
      } catch (error) {
        console.error("Network error during login:", error);
      }
    }

    return {
      productos2,
      nombre,
      correoElectronico,
      direccion,
      datosUsuario,
      productos,
      cantidadTotalProductos,
      productosEnCesta,
      añadirALaCesta,
      selectedCombinacion,
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
      stockProdctuId,
      filtrarPorMarca,
      submitLogin,
      password,
      email,
    };
  },
}).mount("#app");
