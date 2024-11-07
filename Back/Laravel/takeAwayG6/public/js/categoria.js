let btnCreateCategory;
let btnsUpdateCategory;
let btnsDeleteCategory;
let formCategory;

function init() {
    console.log("init");
    formCategory = document.querySelector('#form-category');
    btnCreateCategory = document.querySelector('#btnCreateCategory');
    btnsUpdateCategory = document.querySelectorAll('.btnsUpdateCategory');
    btnsDeleteCategory = document.querySelectorAll('.btnsDeleteCategory');
}

function createCategory() {
    btnCreateCategory.addEventListener('click', function () {
        formCategory.reset();
        formCategory.action = 'http://127.0.0.1:8000/category/create';

        let modal = new bootstrap.Modal(document.querySelector('#modal-category'));
        modal.show();
    })
}

function updateCategory() {
    btnsUpdateCategory.forEach(btnUpdateCategory => {
        btnUpdateCategory.addEventListener('click', function () {
            let idCategory = this.dataset.idCategory;
            formCategory.action = 'http://127.0.0.1:8000/category/update/' + idCategory;
            document.querySelector('#nom').value = this.dataset.nom;
            document.querySelector('#imagenCategory').value = this.dataset.imagen;

            let modal = new bootstrap.Modal(document.querySelector('#modal-category'));
            modal.show();
        })
    })
}

function deleteCategory() {
    btnsDeleteCategory.forEach(btnDeleteCategory => {
        btnDeleteCategory.addEventListener('click', function () {
            let idCategory = this.dataset.idCategory;
            console.log("Id producto eliminada: " + idCategory);
            Swal.fire({
                title: 'Advertencia!',
                html: 'Estas seguro de eliminar este categoria',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes ejecutar la lógica de eliminación
                    console.log("Categoria eliminada: " + idCategory);
                    document.querySelector('.form-delete-' + idCategory).submit();
                }
            });
        })
    });
}

document.addEventListener('DOMContentLoaded', function () {
    init();
    createCategory();
    updateCategory();
    deleteCategory();
});
