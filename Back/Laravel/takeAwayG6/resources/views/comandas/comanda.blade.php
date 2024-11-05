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
                    <p>{{ $comanda }}</p>
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

                            <button class="btn btn-secondary" style="background-color: blue; border-radius: 60%">
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
@endsection

@section('scripts')
    <script src="{{ asset('js/comanda.js') }}"></script>
@endsection
