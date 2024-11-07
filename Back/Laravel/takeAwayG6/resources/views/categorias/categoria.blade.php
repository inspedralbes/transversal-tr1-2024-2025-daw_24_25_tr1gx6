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
            <h1 style="text-align: center;">Categorías</h1>
        </div>
        <div class="inputs">
            <div class="form">
                <button class="btn btn-primary" id="btnCreateCategory"
                    style="border-radius: 10px; background-color: green">Añadir
                    Categoria</button>
            </div>
        </div>
        <div class="items" style="border: 3px solid blue; display: flex; flex-wrap: wrap; gap: 1rem;">
            @foreach ($categorias as $category)
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset(str_replace('./', '', $category->imagen)) }}" class="img-fluid rounded-start"
                                alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $category->nom }}</h5>
                                <div class="buttons">
                                    <button class="btn btn-primary btnsUpdateCategory"
                                        data-id-category="{{ $category->id }}" data-nom="{{ $category->nom }}"
                                        data-imagen="{{ $category->imagen }}">Editar</button>
                                    <button class="btn btn-secondary btnsDeleteCategory" style="background-color: red;"
                                        data-id-category="{{ $category->id }}">Eliminar</button>

                                    <form method="POST" action="{{ route('delete.category', ['id' => $category->id]) }}"
                                        class="form-delete-{{ $category->id }}">
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
    <div class="modal fade" id="modal-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="form-category">
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
                            <input type="text" class="form-control" name="imagen" id="imagenCategory"
                                placeholder="Imagen" aria-label="Desc" aria-describedby="basic-addon1" required>
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
    <script src="{{ asset('js/categoria.js') }}"></script>
@endsection
