@extends('Layout.master')

@section('page-style')
    <style>
        nav {
            background: #000000;
        }
    </style>
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <img src="http://takeawayg6.daw.inspedralbes.cat/Web/Img/Logo.png" class="rounded" style="width: 100px">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" style="color: white" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white">Marcas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('screen.productos') }}" style="color: white">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white">Comandas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white">Comanda Articulos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white">Stocks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white">Users</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown ms-auto">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" style="color: white">
                            <i class="bi bi-list fs-5"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endsection

@section('pages')
    <div class="container">
        <div class="titulo">
            <h1 style="text-align: center; border: 2px solid black;">Stock</h1>

        </div>
        <div class="inputs">
            <div class="form">
                <button class="btn btn-primary" id="btnCreateProduct"
                    style="border-radius: 10px; background-color: green">Añadir Stock</button>
            </div>
        </div>
        <div class="list-cards" style="border: 3px solid black;">
            <div class="row">
                @foreach ($stocks as $stock)
                    <div class="col-md-4 mb-4"> <!-- Ajusta el tamaño de la columna según lo necesites -->
                        <div class="card" style="width: 100%; border: 3px solid blue">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset(str_replace('./', '', $stock->producto->img)) }}" class="card-img-top"
                                    alt="..."
                                    style="width: 80%; height: 10rem; object-fit: cover; margin-bottom: 5px; border:3px solid aqua; align-items:center">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $stock->producto->nom }}</h5>
                                <p class="card-text mb-1"><b>Numero de stock: </b>{{ $stock->Nstock }}</p>
                                <p class="card-text mb-1"><b>Color: </b>{{ $stock->Color }}</p>
                                <p class="card-text mb-1"><b>Talla Camisa: </b>{{ $stock->TallaCamisa ?: 'No es una camisa' }}
                                </p>
                                <p class="card-text mb-1"><b>Talla Zapato: </b>{{ $stock->TallaZapato?: 'No es un zapato' }}</p>
                                <div class="button-group mt-3 mb-1" style="border: 3px solid purple; width: 80%;">
                                    <button class="btn btn-primary btnsUpdateProducto"
                                        data-id-stock='{{ $stock->id }}'>Editar</button>

                                    <button class="btn btn-secondary btnsDeleteProducto" style="background-color: red"
                                        data-id-stock="{{ $stock->id }}">Eliminar</button>

                                    <form method="POST" action="{{ route('delete.product', ['id' => $stock->id]) }}"
                                        class="form-delete-{{ $stock->id }}">
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('forms-cruds')

@endsection

@section('scripts')
@endsection
