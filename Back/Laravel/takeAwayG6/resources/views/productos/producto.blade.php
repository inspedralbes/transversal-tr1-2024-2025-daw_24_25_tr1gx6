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
                        <a class="nav-link" href="#" style="color: white">Tallas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white">Comandas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: white">Comanda Articulos</a>
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
            <h1 style="text-align: center; border: 2px solid black;">Productos</h1>

        </div>
        <div class="inputs">
            <div class="form">
                <button class="btn btn-primary" id="btnCreateProduct"
                    style="border-radius: 10px; background-color: green">Añadir
                    Producto</button>
            </div>
        </div>

        <div class="items" style="border: 2px solid blue;  wrap; gap: 10px;">
            @foreach ($productos as $producto)
                <div class="card" style="width:100%">
                    <div class="card-body d-flex justify-content-between" style="border: 2px solid black;">

                        <div class="image-item"
                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; border: 3px solid red;">
                            <img src="{{ asset(str_replace('./', '', $producto->img)) }}" class="card-img-top"
                                alt="..." style="width: 10rem; height: 10rem; margin-bottom: 5px;">
                        </div>

                        <div class="info-item" style="flex: 1; border: 3px solid green; ">
                            <h5 class="card-title text-center mt-2 mb-1">{{ $producto->nom }}</h5>
                            <p class="card-text mb-1"><b>Descripción: </b> {{ $producto->desc }}</p>

                            <p class="card-text mb-1"><b>Stock: </b>{{ $producto->stock }}
                                <b>Categoria: </b>{{ $producto->category->nom }}
                                <b>Marca: </b>{{ $producto->marca->nom }}
                                <b>Talla: </b>{{ $producto->talla->medida }}
                                <b>Color: </b>{{ $producto->color->nom }}
                            </p>
                            {{-- <p class="card-text mb-1"><b>Categoria: </b>{{ $producto->category->nom }}</p>
                            <p class="card-text mb-1"><b>Marca: </b>{{ $producto->marca->nom }}</p>
                            <p class="card-text mb-1"><b>Talla: </b>{{ $producto->talla->medida }}</p>
                            <p class="card-text mb-1"><b>Color: </b>{{ $producto->color->nom }}</p> --}}

                            <div class="button-group mt-3 mb-1" style="border: 3px solid purple; width: 20%;">
                                <button class="btn btn-primary btnsUpdateProducto"
                                    data-id-Producto='{{ $producto->id }}'>Editar</button>
                                <button class="btn btn-secondary" style="background-color: red">Eliminar</button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('forms-cruds')
    <div class="modal fade" id="modal-productos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="form-productos">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="nom" id="productName" style="width: 100%; height: 2rem;"
                            placeholder="Nombre del producto" required />

                        <input type="text" name="desc" id="productDesc" style="width: 100%; height: 2rem;"
                            placeholder="Descripcion del producto" required />

                        <input type="number" name="stock" id="productStock" style="width: 100%; height: 2rem;"
                            required />

                        <input type="number" name="preu" id="productPreu" step="0.01" min="0"
                            placeholder="0.00" style="width: 100%; height: 2rem;" required />

                        <input type="text" name="img" id="productImg" style="width: 100%; height: 2rem;"
                            required />

                        <!-- Para mostrar las categorías en un select -->
                        <label for="categoria">Categoría:</label>
                        <select name="idCategory" id="categoria">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nom }}</option>
                            @endforeach
                        </select>

                        <!-- Para mostrar las tallas en un select -->
                        <label for="marca">Marca:</label>
                        <select name="idMarca" id="marca">
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->nom }}</option>
                            @endforeach
                        </select>

                        <!-- Para mostrar los colores en un select -->
                        <label for="color">Color:</label>
                        <select name="idColor" id="color">
                            @foreach ($colores as $color)
                                <option value="{{ $color->id }}">{{ $color->nom }}</option>
                            @endforeach
                        </select>

                        <!-- Para mostrar las tallas en un select -->
                        <label for="talla">Talla:</label>
                        <select name="idTalla" id="talla">
                            @foreach ($tallas as $talla)
                                <option value="{{ $talla->id }}">{{ $talla->medida }}</option>
                            @endforeach
                        </select>

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
    <script src="{{ asset('js/productos.js') }}"></script>
@endsection
