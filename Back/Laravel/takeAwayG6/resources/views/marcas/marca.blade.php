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
        <div class="titulo" style="border: 3px solid black;">
            <h1 style="text-align: center;">Marcas</h1>
        </div>
        <div class="inputs">
            <div class="form">
                <button class="btn btn-primary" id="btnCreateMarca" style="border-radius: 10px; background-color: green">Añadir
                    Marca</button>
            </div>
        </div>
        <div class="items" style="border: 3px solid blue; display: flex; flex-wrap: wrap; gap: 1rem;">
            @foreach ($marcas as $marca)
                <div class="card mb-3" style="width: 24rem; flex: 1 1 calc(33.333% - 1rem);">
                        <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset(str_replace('./', '', $marca->imagen)) }}" class="img-fluid rounded-start"
                                alt="..." style="width: 20rem; height: 10rem;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $marca->nom }}</h5>
                                <br>
                                <div class="buttons">
                                    <button class="btn btn-primary btnsUpdateMarca" data-id-marca="{{ $marca->id }}"
                                        data-nom="{{ $marca->nom }}" data-imagen="{{ $marca->imagen }}">Editar</button>
                                    <button class="btn btn-secondary btnsDeleteMarca" style="background-color: red;"
                                        data-id-marca="{{ $marca->id }}">Eliminar</button>

                                    <form method="POST" action="{{ route('delete.marca', ['id' => $marca->id]) }}"
                                        class="form-delete-{{ $marca->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('forms-cruds')
    <div class="modal fade" id="modal-marca" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="form-marca">
                    @csrf
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="nom" id="nom"
                                placeholder="Nombre de la categoria" aria-label="Desc" aria-describedby="basic-addon1"
                                required>
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-person"></i>
                            </span>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="imagen" id="imagenMarca" placeholder="Imagen"
                                aria-label="Desc" aria-describedby="basic-addon1" required>
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-card-image"></i>
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
    <script src="{{ asset('js/marcas.js') }}"></script>
@endsection
