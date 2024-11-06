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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container">
        <h1>Comandas</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Comanda</th>
                    <th>User</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                @foreach ($comandas as $comanda)
                    {{-- <p>{{ $comandas }}</p> --}}
                    {{-- <p>{{$comanda->coman}}</p> --}}
                    <tr>
                        <th>{{ $comanda->id }}</th>
                        <th>{{ $comanda->user->name }}</th>
                        <th id="estadoComanda{{ $comanda->id }}">{{ $comanda->estat }}</th>
                        <th>
                            <button class="btn btn-primary btnsSiguienteComanda"id="btnSiguiente{{ $comanda->id }}"
                                data-id-comanda="{{ $comanda->id }}">Siguiente</button>

                            <button class="btn btn-secondary btnsDeleteComanda" style="background-color: red;"
                                data-id-comanda="{{ $comanda->id }}" data-estat="{{ $comanda->estat }}">Eliminar</button>
                            <button class="btn btn-secondary btnsCancelComanda" data-id-comanda="{{ $comanda->id }}"
                                data-estat="Cancelado">Cancelar</button>

                            <button class="btn btn-info btnsInfoComanda" style="background-color: blue;"
                                data-id-comanda="{{ $comanda->id }}"
                                data-comanda-articulos="{{ json_encode($comanda->comandaArticulo) }}">
                                <i class="bi bi-info-circle"></i>
                            </button>

                            <form method="POST" action="{{ route('delete.comandas', ['id' => $comanda->id]) }}"
                                class="form-delete-{{ $comanda->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </th>
                    </tr>
                @endforeach
            </thead>
            <tbody id="comandasTabla"></tbody>
        </table>
    </div>
@endsection

@section('forms-cruds')
    <!-- Vertically centered scrollable modal -->
    <div class="modal fade" id="modal-comanda-info" tabindex="-1" aria-labelledby="modal-comanda-info-label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-comanda-info-label">Detalles de la Comanda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-comanda-info-body">
                    <!-- Aquí se cargarán los artículos dinámicamente -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/comanda.js') }}"></script>
@endsection
