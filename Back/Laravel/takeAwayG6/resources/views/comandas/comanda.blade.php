@extends('Layout.master')

@section('page-style')
    <style>
        nav {
            background-color: black;
        }

        h1 {
            text-align: center;
            background-color: lightgray;
            border-radius: 7px;
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')
@endsection

@section('pages')
    <div class="container">
        <h1>Comandas</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="comandasTabla"></tbody>
        </table>
    </div>
@endsection

@section('forms-cruds')
@endsection

@section('scripts')
    <script>
        const estados = [
            "Por Confirmar",
            "Confirmado",
            "Preparando",
            "Preparado",
            "Enviado",
            "En Reparto",
            "Entregado"
        ];

        async function fetchComandas() {
            const response = await fetch('/pedidoUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    idUser: 1
                }) // Cambiar por el ID del usuario actual
            });

            if (response.ok) {
                const data = await response.json();
                if (data.status === 'success') {
                    const comandasTabla = document.getElementById('comandasTabla');
                    comandasTabla.innerHTML = '';

                    data.comandaUser.forEach(comanda => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${comanda.id}</td>
                        <td id="estadoComanda${comanda.id}">${comanda.estat}</td>
                        <td>
                            <button id="btnSiguiente${comanda.id}" class="btn btn-primary" onclick="cambiarSiguienteEstado(${comanda.id})" ${comanda.estat === 'Entregado' ? 'disabled' : ''}>Siguiente</button>
                            <button class="btn btn-danger" onclick="eliminarComanda(${comanda.id})">Eliminar</button>
                        </td>
                    `;
                        comandasTabla.appendChild(row);
                    });
                } else {
                    console.error('Error al cargar las comandas');
                }
            } else {
                console.error('Error al cargar las comandas');
            }
        }

        async function cambiarSiguienteEstado(id) {
            const estadoActual = document.getElementById(`estadoComanda${id}`).innerText;
            const currentIndex = estados.indexOf(estadoActual);
            if (currentIndex < estados.length - 1) {
                const newEstado = estados[currentIndex + 1];

                // Actualiza el estado en la base de datos
                const response = await fetch(`/comanda/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        estat: newEstado
                    })
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.status === 'success') {
                        //Actualizar el estado en la tabla
                        document.getElementById(`estadoComanda${id}`).innerText = newEstado;
                        console.log('Estado actualizado a:', newEstado);

                        // Desactivar el botoón si el estado es 'Entregado'
                        if (newEstado === 'Entregado') {
                            document.getElementById(`btnSiguiente${id}`).disabled = true;
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
        }
        async function eliminarComanda(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta comanda?")) {
                const response = await fetch(`/comanda/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.status === 'success') {
                        console.log('Comanda eliminada');
                        fetchComandas();
                    } else {
                        console.error('Error al eliminar la comanda');
                    }
                } else {
                    console.error('Error al hacer la solicitud de eliminación');
                }
            }
        }

        window.onload = fetchComandas;
    </script>
@endsection
