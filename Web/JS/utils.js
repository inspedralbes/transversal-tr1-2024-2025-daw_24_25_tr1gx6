import {
  createApp,
  ref,
  onMounted,
} from "https://unpkg.com/vue@3/dist/vue.esm-browser.js";

createApp({
  setup() {
    const productos = ref([]);
    const productosEnCesta = ref([]);
    const divActivo = ref("paginaPrincipal");
    const cestaActiva = ref(false);
    const finalitzaCompraActiva = ref(false);
    const precioTotal = ref(0);

    function getProductos() {
      fetch("./JS/ropa.json")
        .then((response) => response.json())
        .then((data) => {
          productos.value = data;
        })
        .catch((error) => console.error("Error fetching productos:", error));
    }

    function añadirALaCesta(index) {
        const productoSeleccionado = productos.value[index];
        const productoEnCesta = productosEnCesta.value.find(producto => producto.nombre === productoSeleccionado.nombre);
        
        // Si el producto ya está en la cesta, incrementa la cantidad
        if (productoEnCesta) {
          productoEnCesta.cantidad++;
        } else {
          // Si no está en la cesta, añade el producto con cantidad 1
          // const nuevoProducto = { ...productoSeleccionado, cantidad: 1 }; 
          const nuevoProducto = Object.assign({},productoSeleccionado, { cantidad: 1 }); 

          productosEnCesta.value.push(nuevoProducto);
        }
      
        cestaActiva.value = true;
        finalitzaCompraActiva.value = true;
        actualizarPrecioTotal();
      }
      

    // funcion para restarCantidad
    function restarCantidad(index) {
      const producto = productosEnCesta.value[index];

      if (producto.cantidad > 1) {
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
        productosEnCesta.value.splice(index, 1);
        actualizarPrecioTotal();

        if(productosEnCesta.value.length === 0){
            finalitzaCompraActiva.value = false;
        }

    }

    function actualizarPrecioTotal() {
      precioTotal.value = 0;

      for (let i = 0; i < productosEnCesta.value.length; i++) {
        precioTotal.value += productosEnCesta.value[i].precio * productosEnCesta.value[i].cantidad;
      }
    }

    function cambiarACarrito() {
      divActivo.value = "carrito";
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
      if (cestaActiva.value) {
        cestaActiva.value = false;
      } else {
        cestaActiva.value = true;
      }
    }
    function volverALaPaginaPrincipal() {
      divActivo.value = "paginaPrincipal";
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
      toggleCesta,
      finalitzaCompraActiva,
      precioTotal,
      divActivo,
      cambiarACarrito,
      volverALaPaginaPrincipal,
    };
  },
}).mount("#app");
