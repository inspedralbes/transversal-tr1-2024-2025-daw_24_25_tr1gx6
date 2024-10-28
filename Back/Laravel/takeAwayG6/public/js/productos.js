let btnCreateProducto;
let formProductos;
let btnsUpdateProducto;


function init() {
    console.log("init");
    formProductos = document.querySelector('#form-productos');

    btnCreateProducto = document.querySelector('#btnCreateProduct');
    btnsUpdateProducto = document.querySelectorAll('.btnsUpdateProducto');
}

function createProducto() {
    btnCreateProducto.addEventListener('click', function () {
        formProductos.action = 'http://127.0.0.1:8000/api/productos/create';
        let modal = new bootstrap.Modal(document.querySelector('#modal-productos'));
        modal.show();
    });
}

function updateProducto() {
    btnsUpdateProducto.forEach(btnUpdateProducto => {
        btnUpdateProducto.addEventListener('click', function () {
            let idProducto = this.dataset.idProducto;
            formProductos.action = 'http://127.0.0.1:8000/api/productos/update' + idProducto;
            document.querySelector('#productName').value = this.dataset.nom;
            document.querySelector('#productDesc').value = this.dataset.desc;
            document.querySelector('#productStock').value = this.dataset.stock;
            document.querySelector('#productPreu').value = this.dataset.preu;
            document.querySelector('#productImg').value = this.dataset.img;
            document.querySelector('#categoria').value = this.dataset.idCategory;
            document.querySelector('#marca').value = this.dataset.idMarca;
            document.querySelector('#color').value = this.dataset.idColor;
            document.querySelector('#talla').value = this.dataset.idTalla;


            let modal = new bootstrap.Modal(document.querySelector('#modal-productos'));
            modal.show();
        })
    });
}

document.addEventListener('DOMContentLoaded', function () {
    init();
    createProducto();
    updateProducto();
});
