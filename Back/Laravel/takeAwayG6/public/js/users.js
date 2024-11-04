let btnCreateUser;
let formUser;
let btnsUpdateUser;
let btnsDeleteUser;

function init() {
    console.log("init");
    formUser = document.querySelector('#form-user');

    btnCreateUser = document.querySelector('#btnCreateUser');
    btnsDeleteUser = document.querySelectorAll('.btnsDeleteUser');
    btnsUpdateUser = document.querySelectorAll('.btnsUpdateUser');
}

function createUser() {
    btnCreateUser.addEventListener('click', function () {
        formUser.reset();
        formUser.action = 'http://127.0.0.1:8000/user/create';

        let modal = new bootstrap.Modal(document.querySelector('#modal-user'))
        modal.show();
    })
}

function updateUser() {
    btnsUpdateUser.forEach(btnUpdateUser => {
        btnUpdateUser.addEventListener('click', function () {
            let idUser = this.dataset.idUser;
            formUser.action = 'http://127.0.0.1:8000/user/update/'+idUser;


            document.querySelector('#Name').value = this.dataset.name;
            document.querySelector('#Email').value = this.dataset.email;
            document.querySelector('#Password').value = this.dataset.password;

            let modal = new bootstrap.Modal(document.querySelector('#modal-user'))
            modal.show();
        })
    })
}

function deleteUser() {
    btnsDeleteUser.forEach(btnDeleteUser => {
        btnDeleteUser.addEventListener('click', function () {
            let idUser = this.dataset.idUser;
            console.log("Id producto eliminada: " + idUser);
            Swal.fire({
                title: 'Advertencia!',
                html: 'Estas seguro de eliminar este usuario',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes ejecutar la lógica de eliminación
                    console.log("Categoria eliminada: " + idUser);
                    document.querySelector('.form-delete-' + idUser).submit();
                }
            });
        })
    })
}

document.addEventListener('DOMContentLoaded', function () {
    init();
    createUser();
    deleteUser();
    updateUser();
});