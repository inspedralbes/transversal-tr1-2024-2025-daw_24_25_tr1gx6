let btnCreateProducto;
let formProductos;
let btnsUpdateProducto;
let btnsDeleteProducto;
let token;


function init() {
    console.log("init");
    /*
    // productos.js
    const authToken = document.querySelector('meta[name="auth-token"]').getAttribute('content');
    console.log(authToken); // Esto mostrará el token en la consola*/

    formProductos = document.querySelector('#form-productos');

    btnCreateProducto = document.querySelector('#btnCreateProduct');
    btnsUpdateProducto = document.querySelectorAll('.btnsUpdateProducto');
    btnsDeleteProducto = document.querySelectorAll('.btnsDeleteProducto');
}

function createProducto() {
    btnCreateProducto.addEventListener('click', function () {
        // Limpiar los campos del formulario
        formProductos.reset();
        formProductos.action = 'http://127.0.0.1:8000/productos/create';
        let modal = new bootstrap.Modal(document.querySelector('#modal-productos'));
        modal.show();
    });
}

function updateProducto() {
    btnsUpdateProducto.forEach(btnUpdateProducto => {
        btnUpdateProducto.addEventListener('click', function () {
            let idProducto = this.dataset.idProducto;

            formProductos.action = 'http://127.0.0.1:8000/productos/update/' + idProducto;
            document.querySelector('#productName').value = this.dataset.nom;
            document.querySelector('#productDesc').value = this.dataset.desc;
            document.querySelector('#productPreu').value = this.dataset.preu;
            document.querySelector('#productImg').value = this.dataset.img;
            document.querySelector('#categoria').value = this.dataset.idCategory;
            document.querySelector('#marca').value = this.dataset.idMarca;


            let modal = new bootstrap.Modal(document.querySelector('#modal-productos'));
            modal.show();
        })
    });
}

function deleteProducto() {
    btnsDeleteProducto.forEach(btnDeleteProducto => {
        btnDeleteProducto.addEventListener('click', function () {
            let idProducto = this.dataset.idProducto;
            console.log("Id producto eliminada: " + idProducto);
            Swal.fire({
                title: 'Advertencia!',
                html: 'Estas seguro de eliminar este producto',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes ejecutar la lógica de eliminación
                    console.log("Categoria eliminada: " + idProducto);
                    document.querySelector('.form-delete-' + idProducto).submit();
                }
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    init();
    createProducto();
    updateProducto();
    deleteProducto();
});
