let btnCreateStock;
let formStock;
let inputCategory;
let btnsUpdateStock;
let btnsDeleteStock;

function init() {
    console.log("init");
    btnCreateStock = document.querySelector('#btnCreateStock');
    formStock = document.querySelector('#form-stock');
    inputCategory = document.querySelector('#nomProducto');
    btnsUpdateStock = document.querySelectorAll('.btnsUpdateStock');
    btnsDeleteStock = document.querySelectorAll('.btnsDeleteStock');
}

function actualizarInput() {
    inputCategory.addEventListener('change', function () {
        let selectOption = this.options[this.selectedIndex];

        let categoria = selectOption.getAttribute('data-nom-category');

        document.querySelector('#categoriaInput').value = categoria;
    });
}

function createStock() {
    btnCreateStock.addEventListener('click', function () {
        formStock.reset();
        formStock.action = 'http://127.0.0.1:8000/stock/create';
        let modal = new bootstrap.Modal(document.querySelector('#modal-stock'))
        modal.show();
    });
}

function updateStock() {
    btnsUpdateStock.forEach(btnUpdateStock => {
        btnUpdateStock.addEventListener('click', function () {
            actualizarInput();
            let idStock = this.dataset.idStock;
            formStock.action = 'http://127.0.0.1:8000/stock/update/' + idStock;

            document.querySelector('#nomProducto').value = this.dataset.nomProducto;
            document.querySelector('#nstock').value = this.dataset.nStock;
            document.querySelector('#color').value = this.dataset.color;
            document.querySelector('#tallacamisa').value = this.dataset.tallaCamisa;
            document.querySelector('#tallazapato').value = this.dataset.tallaZapato;

            // Deshabilitar el campo de entrada de color
            document.querySelector('#nomProducto').disabled = true;
            document.querySelector('#categoriaInput').style.display = 'none';
            document.querySelector('#basic-addon1').style.display = 'none';
            document.querySelector('#color').disabled = true;
            document.querySelector('#tallacamisa').disabled = true;
            document.querySelector('#tallazapato').disabled = true;

            let modal = new bootstrap.Modal(document.querySelector('#modal-stock'))
            modal.show();
        });
    });
}

function deleteStock() {
    btnsDeleteStock.forEach(btnDeleteStock => {
        btnDeleteStock.addEventListener('click', function () {
            let idStock = this.dataset.idStock;
            console.log("Id producto eliminada: " + idStock);
            Swal.fire({
                title: 'Advertencia!',
                html: 'Estas seguro de eliminar este stock del producto',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes ejecutar la lógica de eliminación
                    console.log("Categoria eliminada: " + idStock);
                    document.querySelector('.form-delete-' + idStock).submit();
                }
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    init();
    createStock();
    actualizarInput();
    updateStock();
    deleteStock();
});