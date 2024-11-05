let btnsSiguienteComanda;
let btnsDeleteComanda;
let btnsCancelComanda;

const estados = [
    "Por Confirmar",
    "Confirmado",
    "Preparando",
    "Preparado",
    "Enviado",
    "En Reparto",
    "Entregado",
    "Cancelado"
];

function init() {
    console.log("init");
    btnsSiguienteComanda = document.querySelectorAll('.btnsSiguienteComanda');
    btnsDeleteComanda = document.querySelectorAll('.btnsDeleteComanda');
    btnsCancelComanda = document.querySelectorAll('.btnsCancelComanda');
}


async function cambiarSiguienteEstado() {
    btnsSiguienteComanda.forEach(btnSiguienteComanda => {
        btnSiguienteComanda.addEventListener('click', async function () {
            const idComanda = this.dataset.idComanda;
            console.log("ID COMANDA: ", idComanda);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const estadoActual = document.getElementById(`estadoComanda${idComanda}`).innerText;
            const currentIndex = estados.indexOf(estadoActual);
            if (currentIndex < estados.length - 1) {
                const newEstado = estados[currentIndex + 1];

                // Actualiza el estado en la base de datos
                const response = await fetch(`/comanda/update/${idComanda}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        estat: newEstado
                    })
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.status === 'success') {
                        //Actualizar el estado en la tabla
                        document.getElementById(`estadoComanda${idComanda}`).innerText = newEstado;
                        console.log('Estado actualizado a:', newEstado);

                        // Desactivar el botoón si el estado es 'Entregado'
                        if (newEstado === 'Entregado') {
                            document.getElementById(`btnSiguiente${idComanda}`).disabled = true;
                        }
                    } else {
                        console.error('Error al actualizar el estado');
                    }
                } else {
                    console.error('Error al hacer la solicitud');
                }
            } else {
                console.log('La comanda ya está en el último estado.');
            }
        })
    })
}

async function cancelarComanda() {
    btnsCancelComanda.forEach(btnCancelComanda => {
        btnCancelComanda.addEventListener('click', async function () {
            const idComanda = this.dataset.idComanda;
            const estat = this.dataset.estat;
            console.log("ID COMANDA: ", idComanda);
            console.log("Estado: ", estat);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Actualiza el estado en la base de datos
            const response = await fetch(`/comanda/cancel/${idComanda}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    estat: estat
                })
            });

            if (response.ok) {
                const data = await response.json();

                if (data.status === 'success') {
                    //Actualizar el estado en la tabla
                    document.getElementById(`estadoComanda${idComanda}`).innerText = estat;
                    console.log('Estado actualizado a:', estat);

                    // Desactivar el botoón si el estado es 'Entregado'
                    if (estat === 'Cancelado') {
                        document.getElementById(`btnSiguiente${idComanda}`).disabled = true;
                    }
                } else {
                    console.error('Error al actualizar el estado');
                }
            } else {
                console.error('Error al hacer la solicitud');
            }

        })
    });
}

async function eliminarComanda() {
    btnsDeleteComanda.forEach(btnDeleteComanda => {
        btnDeleteComanda.addEventListener('click', function () {
            const idComanda = this.dataset.idComanda;

            console.log("Id producto eliminada: " + idComanda);
            // Obtén el estado actualizado del DOM
            const estadoActualElemento = document.getElementById(`estadoComanda${idComanda}`);
            const estatActual = estadoActualElemento ? estadoActualElemento.innerText : null;

            console.log("Estado actual de la comanda: " + estatActual);

            // Verificar si el estado es "Entregado"
            if (estatActual === "Entregado" && estatActual === "Cancelado") {
                Swal.fire({
                    title: 'Advertencia!',
                    html: 'Estas seguro de eliminar esta comanda',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Aquí puedes ejecutar la lógica de eliminación
                        console.log("Categoria eliminada: " + idComanda);
                        document.querySelector('.form-delete-' + idComanda).submit();
                    }
                });

            } else {
                // Mostrar mensaje de advertencia si no está en "Entregado"
                Swal.fire({
                    title: 'No se puede eliminar',
                    text: 'Solo puedes eliminar una comanda cuando su estado es "Entregado" o "Cancelado"',
                    icon: 'info',
                    confirmButtonText: 'Aceptar'
                });
            }

        });
    })
}

document.addEventListener('DOMContentLoaded', function () {
    init();
    cambiarSiguienteEstado();
    eliminarComanda();
    cancelarComanda();
});
