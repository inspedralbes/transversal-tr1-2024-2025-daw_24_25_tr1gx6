@extends('Layout.master')

@section('page-style')
    <style>
        nav {
            background: #000000;
        }
    </style>
@endsection

@section('content')
@endsection

@section('pages')
    <div class="container">
        <div class="titulo">
            <h1 style="border: 3px solid black; text-align: center;">Users</h1>
        </div>

        <div class="inputs">
            <div class="form">
                <button class="btn btn-primary" id="btnCreateUser" style="border-radius: 10px; background-color: green">Añadir
                    usuario</button>
            </div>
        </div>

        <div class="items" style="border: 3px solid blue;">
            <div class="row">
                @foreach ($users as $user)
                    <div class="col-md-3 mb-3"> <!-- Ajusta el tamaño de la columna según lo necesites -->
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $user->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">{{ $user->email }}</h6>
                                <p class="card-text"><b>Rol: </b>{{ $user->rol }} </p>
                                <div>
                                    <button class="btn btn-primary btnsUpdateUser" data-id-user="{{ $user->id }}"
                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                        data-password="{{ $user->password }}">Editar</button>
                                    <button class="btn btn-secondary btnsDeleteUser" style="background-color: red;"
                                        data-id-user="{{ $user->id }}">Eliminar</button>

                                    <form method="POST" action="{{ route('delete.user', ['id' => $user->id]) }}"
                                        class="form-delete-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @foreach ($users as $user)
                <form action="{{ route('update.user', $user->id) }}" method="POST">
                    @csrf
                    <input type="text" value="{{ $user->name }}" name="name" required>
                    <input type="text" value="{{ $user->email }}" name="email" required>
                    <input type="text" value="{{ $user->password }}" name="password" required>
                    <input type="text" value="{{ $user->rol }}" name="rol" required>
                    <button type="submit">Actualiza</button>
                </form>
                <p>{{ $user->name }}</p>
                <p>{{ $user->email }}</p>
                <p>{{ $user->password }}</p>
                <form action="{{ route('delete.user', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit">Eliminar</button>
                </form>
            @endforeach
            <form action="{{ route('create.user') }}" method="POST">
                @csrf
                <input type="text" name="name" required>
                <input type="text" name="email" required>
                <input type="text" name="password" required>
                <input type="text" name="rol" required>
                <button type="submit">Registrar usuario</button>
            </form>
        </div>
    </div>
@endsection
@section('forms-cruds')
    <div class="modal fade" id="modal-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="form-user">
                    @csrf
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="name" id="Name"
                                placeholder="nombre del usuario" aria-label="Desc" aria-describedby="basic-addon1" required>
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-person"></i>
                            </span>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="email" id="Email"
                                placeholder="Email del usuario" aria-label="Desc" aria-describedby="basic-addon1" required>
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-envelope"></i>
                            </span>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" id="Password"
                                placeholder="Password" aria-label="Desc" aria-describedby="basic-addon1" required>
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-blockquote-left"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="background-color: red">Cancelar</button>
                        <button type="submit" class="btn btn-primary" style="background-color: green">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/users.js') }}"></script>
@endsection
