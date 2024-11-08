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
  login,
  register,
  confirmarCompra,
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
      { nombre: "accesorio", imagen: ""}
    ]);
    const filtros = reactive({
      categoria: "todo",
      marca: "todo",
      precio: "todo",
    });
    const productos = ref([]);
    let productos2 = ref([]);
    const prodMostrados = ref([]);
    const categMostradas = ref([]);
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
    const passwordRegister = ref("");
    const emailRegister = ref("");
    const UserName = ref("");
    const rol = ref("");
    const infoUser = ref([]);

    async function getProductos() {
      await fetch("http://localhost:8000/api/getProductos")
        .then((response) => response.json())
        .then((data) => {
          console.log('Hola', data);
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

    async function cargar() {
      const data = await getProductoss();
      console.log('front', data);
      productos.value = data;
      mostrarProds();
      setTimeout(() => {
        mostrarCategs(); 
      }, 1000);
      console.log(productos.value);

      // if (Array.isArray(data) && data.length > 0) {
      //   productos.value = data;
      //   productos2.value = data;
      //   console.log(productos.value); // Verificar que cada producto tenga category y marca
      // } else {
      //   console.error(
      //     "No se encontraron productos o la respuesta no es válida."
      //   );
      // }

    }

    //Funciones para el movimiento del LandPage
    // Función para alternar entre productos más valorados
    function mostrarProds() {
      const millorsProds = productos.value
          .sort((a, b) => b.valoracion - a.valoracion)
          .slice(0, 12);

      let index = 0;

      setInterval(() => {
          prodMostrados.value = [...millorsProds.slice(index, index + 4)];
          index = (index + 4) % millorsProds.length;
      }, 3000);
  }

  // Función para alternar entre las mitades de las categorías 
  function mostrarCategs() {
      const mitad = Math.ceil(categorias.value.length / 2); // Encontrar la mitad
      const primeraMitad = categorias.value.slice(0, mitad);
      const segundaMitad = categorias.value.slice(mitad); 

      let index = 0;

      setInterval(() => {
          if (index === 0) {
              categMostradas.value = primeraMitad;
          } else {
              categMostradas.value = segundaMitad;
          }
          index = (index + 1) % 2;
      }, 3000);
  }

    // funcion para guardar en local storage
    function guardarCarrito() {
      localStorage.setItem(
        "productosEnCesta",
        JSON.stringify(productosEnCesta.value)
      );
      actualizarPrecioTotal();
    }

    function cargarCarrito() {
      const carritoGuardado = localStorage.getItem("productosEnCesta");
      if (carritoGuardado) {
        productosEnCesta.value = JSON.parse(carritoGuardado);
        // Actualizar finalitzaCompraActiva basado en si hay productos
        finalitzaCompraActiva.value = productosEnCesta.value.length > 0;
        actualizarPrecioTotal();
      } else {
        productosEnCesta.value = []; //inicializar como array vacio si no hay datos
        finalitzaCompraActiva.value = false;
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
    function añadirALaCesta() {
      if (!producto1.value || !stockProdctuId.value) {
        console.log("Producto o stock no disponible");
        return;
      }
      if (stockProdctuId.value.length == 0) {
        console.log("No hay stock de este producto");
        window.alert('No hay stock');
        return;
      }
      cestaActiva.value = true;
      // Ya tenemos el producto directamente desde producto1
      const productoSeleccionado = producto1.value;
      const tallaSeleccionada = stockProdctuId.value.find(
        combinacion => combinacion.id === selectedCombinacion.value
      );

      // Log para verificar la combinación seleccionada
      console.log("Selected Combination:", selectedCombinacion.value);
      console.log("Talla Seleccionada:", tallaSeleccionada);

      // Crear un nuevo objeto del producto
      const nuevoProducto = {
        id: productoSeleccionado.id,
        nom: productoSeleccionado.nom,
        img: productoSeleccionado.img,
        preu: productoSeleccionado.preu,
        stock: productoSeleccionado.stock,
        category: productoSeleccionado.category,
        marca: productoSeleccionado.marca,
        desc: productoSeleccionado.desc,
        cantidad: 1,
        talla: tallaSeleccionada ? (tallaSeleccionada.TallaCamisa || tallaSeleccionada.TallaZapato) : 'Sin talla',
        color: tallaSeleccionada ? tallaSeleccionada.Color : 'Sin color',
        idStock: selectedCombinacion.value,
      };

      console.log("Nuevo producto:", nuevoProducto);

      // Buscar si el producto ya existe en la cesta con la misma combinación
      const productoEnCesta = productosEnCesta.value.find(
        producto =>
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
      }, 2000);
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
    let producto1 = ref({});
    function getProducte(id) {
      producto1.value = productos.value.find(producto => producto.id === id);

      if (producto1) {
        veureProd.value = id;
        divActivo.value = "producte-item";

        console.log("Front id: ", id);

        const idProducto = id;


        productobyID({ idProducto })
          .then((detallesProducto) => {
            console.log("Antes del if:", detallesProducto);
            stockProdctuId.value = detallesProducto;
            console.log(stockProdctuId.value)
            if (detallesProducto && typeof detallesProducto === 'object') {
              producto1.category = producto1.category || { nom: "" };
              producto1.marca = producto1.marca || { nom: "" };

              console.log("Detalles del producto:", producto1);
            } else {
              console.error("No se encontraron detalles para el producto.");
            }
          })
          .catch((error) => {
            console.error("Error al obtener detalles del producto:", error);
          });
      } else {
        console.log("El ID del producto no es válido:", id);
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

    async function procesarCompra() {
      let user = JSON.parse(localStorage.getItem('user'));

      const comandaData = {
        idUser: user.id,
        estat: "Por Confirmar",
        total: precioTotal.value,
      };

      console.log("JSON COMPRA: ", comandaData);


      await createComanda(comandaData)
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
            window.alert('Comprar realizada correctamente')
            console.log("Compra finalizada correctamente");
            productosEnCesta.value = [];
            const tipo = 'confirm';
            confirmarCompra(tipo);
            guardarCarrito();
            actualizarPrecioTotal();
            finalitzaCompraActiva.value = false;
            divActivo.value = "paginaDeInicio";
          } else {
            console.log("Error!! al procesar los productos en la comanda");
          }
        })
        .catch((error) => {
          console.error("Error en el proceso de compra:", error);
        });
    }

    function infoUsuario() {
      const user = {
        user: JSON.parse(localStorage.getItem('user')) || {
          name: '',
          email: '',
          direccion: '',
          metodoPago: ''
        }, // Cargar los datos del usuario desde localStorage
      }

      console.log("Usuario: ", user);

      infoUser.value = user;

      console.log("JSON HECHO: ", infoUser.value);
      
      return infoUser;
    }

    function volverACarrito() {
      divActivo.value = "carrito";
      cestaActiva.value = false;
    }

    function irABotiga() {
      productos2.value = productos.value;
      divActivo.value = "paginaPrincipal";
      cestaActiva.value = false;
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
      const user = localStorage.getItem('user');

      if (user) {
        divActivo.value = 'perfil';
      } else {
        divActivo.value = 'divLogin';
        cestaActiva.value = false;
      }
    }
    function cerrarSesion() {
      localStorage.removeItem('user');
      localStorage.removeItem('token')
      window.alert('Sesion cerrada correctamente.')
      divActivo.value = 'paginaDeInicio';
    }

    function volverALaPaginaPrincipal() {
      divActivo.value = "paginaPrincipal";
      cestaActiva.value = false;
    }

    onMounted(() => {
      //getProductos();
      cargarCarrito();
      cargar();
      infoUsuario();
    });
    function filtrar() {
      productos2.value = productos.value.filter((producto) => {
        const cumpleCategoria =
          filtros.categoria === "todo" ||
          (producto.category && producto.category.nom === filtros.categoria);

        const cumpleMarca =
          filtros.marca === "todo" ||
          (producto.marca && producto.marca.nom === filtros.marca);

        //const cumpleColor = 
        let cumplePrecio = true;
        const precioProducto = producto.preu || 0;

        switch (filtros.precio) {
          case "<=50":
            cumplePrecio = precioProducto <= 50;
            break;
          case "<=100":
            cumplePrecio = precioProducto <= 100;
            break;
          case "<=125":
            cumplePrecio = precioProducto <= 125;
            break;
          case "<=150":
            cumplePrecio = precioProducto <= 150;
            break;
          case "<=175":
            cumplePrecio = precioProducto <= 175;
            break;
          case "<=200":
            cumplePrecio = precioProducto <= 200;
            break;
          default:
            cumplePrecio = true;
        }
        return cumpleCategoria && cumpleMarca && cumplePrecio;
      });
    }
    function cambioFiltros() {
      filtros.categoria = document.querySelector(".categoria").value;
      filtros.marca = document.querySelector(".marca").value;
      filtros.precio = document.querySelector(".precio").value;
      filtrar();
    }
    function IrRegistro() {
      divActivo.value = 'registrarse';
    }
    // function filtrarPorCategoria(){
    //   productos2.value = [];

    //   let categoria = document.querySelector(".categoria").value;
    //   console.log("te has metido en el filtro de categorias");
    //   console.log(productos2.value)
    //   if(categoria != "todo"){
    //     for (let i = 0; i < productos.value.length; i++) {
    //       console.log("hola")
    //       if(productos.value[i].category.nom === categoria){
    //         productos2.value.push(productos.value[i]);
    //         }
    //       }
    //   }else{
    //     productos2.value = productos.value;
    //   }
    // }
    // function filtrarPorMarca(){
    //   productos2.value = [];

    //   let marca = document.querySelector(".marca").value;

    //   if(marca != "todo"){
    //     for (let i = 0; i < productos.value.length; i++) {
    //       if(productos.value[i].marca.nom === marca){
    //         productos2.value.push(productos.value[i]);
    //       }
    //     }
    //   }else{
    //     productos2.value = productos.value;
    //   }
    //}
    async function submitLogin() {
      try {
        const response = await fetch("http://localhost:8000/api/loginUser", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: email.value,
            password: password.value,
          }),
        });
        const data = await response.json();
        console.log('respuesta data', data)
        if (data.login == true) {
          alert('Sesion iniciada');
          localStorage.setItem('user', JSON.stringify({
            name: UserName.value,
            email: emailRegister.value,
          }));
          divActivo.value = 'paginaDeInicio';
        } else {
          window.alert('Contraseña incorrecta')
          document.querySelector(".email").value = '';
          document.querySelector(".pass").value = '';
        }
      } catch (error) {
        console.error("Network error during login:", error);
      }
    }

    async function loginToken() {

      const jsonUser = {
        "email": document.querySelector('#email').value,
        "password": document.querySelector('#password').value,
      }

      let response = await login(jsonUser);

      console.log(response);

      if (response.status == "success") {
        localStorage.setItem('token', response.token)
        localStorage.setItem('user', JSON.stringify(response.user));
        divActivo.value = 'paginaDeInicio';
      } else {
        window.alert('Contraseña incorrecta')
        document.querySelector("#email").value = '';
        document.querySelector("#password").value = '';
      }

    }

    async function registerToken() {

      const jsonUser = {
        "name": document.querySelector('#name').value,
        "email": document.querySelector('#email').value,
        "password": document.querySelector('#password').value
      }

      let response = await register(jsonUser);

      console.log(response);

      if (response.status == "success") {
        localStorage.setItem('token', response.token)
        localStorage.setItem('user', JSON.stringify(response.user));
        divActivo.value = 'paginaDeInicio';
      } else {
        window.alert('Contraseña incorrecta')
        document.querySelector("#name").value = '';
        document.querySelector("#email").value = '';
        document.querySelector("#password").value = '';
      }


    }
    async function submitRegister() {
      const request = {
        name: UserName.value,
        email: emailRegister.value,
        password: passwordRegister.value,
      }

      console.log(request);

      const response = await fetch("http://localhost:8000/api/createUser", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(request),
      });
      const data = await response.json();
      console.log('respuesta data Registro', data)
      if (data.success) {
        window.alert('Usuario registrado correctamente');
        divActivo.value = 'divLogin';
      }
    }
    function filtroCategoriasPulsar(idCategoria) {
      console.log(idCategoria)
      switch (idCategoria) {
        case 0:
          filtros.categoria = 'zapatillas'
          break;
        case 1:
          filtros.categoria = 'sudadera'
          break;
        case 2:
          filtros.categoria = 'pantalon'
          break;
        case 3:
          filtros.categoria = 'chaqueta'
          break;
        case 4:
          filtros.categoria = 'camiseta'
          break;
        case 5:
          filtros.categoria = 'chandal'
          break;
        case 6:
          filtros.categoria = 'chaleco'
          break;
      }
      filtrar();
      divActivo.value = 'paginaPrincipal';
    }
    return {
      productos2,
      nombre,
      correoElectronico,
      direccion,
      datosUsuario,
      productos,
      prodMostrados,
      categMostradas,
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
      categorias,
      categoriaFiltrada,
      IrLogin,
      eliminarDeLaCesta,
      getProducte,
      veureProd,
      stockProdctuId,
      filtrar,
      submitLogin,
      password,
      email,
      filtros,
      cambioFiltros,
      producto1,
      filtroCategoriasPulsar,
      IrRegistro,
      submitRegister,
      passwordRegister,
      emailRegister,
      UserName,
      rol,
      cerrarSesion,
      loginToken,
      registerToken,
      infoUser
    };
  },
}).mount("#app");
