let btnCreateMarca;
let btnsUpdateMarca;
let btnsDeleteMarca;
let formMarca;

function init() {
    console.log("init");
    formMarca = document.querySelector('#form-marca');
    btnCreateMarca = document.querySelector('#btnCreateMarca');
    btnsUpdateMarca = document.querySelectorAll('.btnsUpdateMarca');
    btnsDeleteMarca = document.querySelectorAll('.btnsDeleteMarca');
}

function createMarca() {
    btnCreateMarca.addEventListener('click', function () {
        formMarca.reset();
        formMarca.action = 'http://127.0.0.1:8000/marca/create';

        let modal = new bootstrap.Modal(document.querySelector('#modal-marca'));
        modal.show();
    })
}

function updateMarca() {
    btnsUpdateMarca.forEach(btnUpdateMarca => {
        btnUpdateMarca.addEventListener('click', function () {
            let idMarca = this.dataset.idMarca;
            formMarca.action = 'http://127.0.0.1:8000/marca/update/' + idMarca;
            document.querySelector('#nom').value = this.dataset.nom;
            document.querySelector('#imagenMarca').value = this.dataset.imagen;

            let modal = new bootstrap.Modal(document.querySelector('#modal-marca'));
            modal.show();
        })
    })
}

function deleteMarca() {
    btnsDeleteMarca.forEach(btnDeleteMarca => {
        btnDeleteMarca.addEventListener('click', function () {
            let idMarca = this.dataset.idMarca;
            console.log("Id producto eliminada: " + idMarca);
            Swal.fire({
                title: 'Advertencia!',
                html: 'Estas seguro de eliminar esta categoria',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes ejecutar la lógica de eliminación
                    console.log("Categoria eliminada: " + idMarca);
                    document.querySelector('.form-delete-' + idMarca).submit();
                }
            });
        })
    });
}

document.addEventListener('DOMContentLoaded', function () {
    init();
    createMarca();
    updateMarca();
    deleteMarca();
});
