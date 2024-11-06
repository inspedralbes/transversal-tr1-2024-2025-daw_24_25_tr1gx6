@extends('Layout.master')

@section('page-style')
    <style>
        nav {
            background: #000000;
        }
        .list-info p {
            border: 3px solid coral;
            margin: 1rem;
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
                        <a class="nav-link" href="{{ route('screen.stocks') }}" style="color: white">Stocks</a>
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
            <h1 style="text-align: center; border: 2px solid black;">Bienvenido {{ Auth::user()->name }}</h1>
        </div>
        <div class="informacion" style="border: 3px solid red; padding:2rem;">
            <h2>Bienvenido a la Gestión de FakeLocker</h2>
            <p>En nuestra plataforma, tendrás la capacidad de gestionar de maneras eficientes todos los aspectos
                relacionados con nuestros productos. Aquí podrás:</p>
            <div class="list-info" style="border: 3px solid purple; margin: 1rem;">
                <lu>
                    <li>
                        <b>Añadir Productos</b>
                        <p>Podrás agregar nuevos productos, donde deberás asegurar que todos los detalles del producto como
                            el nombre, la descripción, precio, imagen marca y categoría.</p>
                    </li>
                    <li>
                        <b>Editar Productos</b>
                        <p>Podrás modificar nuestros productos ya existentes, para mantener siempre actualizada la
                            información
                            de nuestros productos.</p>
                    </li>
                    <li>
                        <b>Gestionar Pedidos</b>
                        <p>Podrás llevar un control detallado de los pedidos que han realizado nuestros clientes,
                            permitiéndote
                            gestionar el estado en el que está el perdido y así asegurar un excelente servicio al cliente.
                        </p>
                    </li>
                    <li>
                        <b>Administrar Stock</b>
                        <p>Monitorear y actualizar el inventario de un producto, garantizando que siempre tengas la cantidad
                            adecuada en stock para satisfacer la demanda.</p>
                    </li>
                    <li>
                        <b>Ornaganizar Marcas y Categorías</b>
                        <p>Podrás añadir, editar o eliminar marcas y categorías, esto nos ayuda clasificar nuestros
                            productos de una manera eficiente, también así poder facilitar la navegación y búsqueda tanto
                            para tu como para los clientes.</p>
                    </li>
                </lu>
            </div>
        </div>
    </div>
@endsection


{{-- @section('footer')
    <footer>
        <div class="footer-page" style="border: 3px solid green;">
            <div class="info-footer" style="display: flex; justify-content: center;">
                <p>Derechos de autor © 2023. Mi sitio web.</p>
                <p>Contáctanos: <a href="mailto:info@misitioweb.com">info@misitioweb.com</a></p>
                <ul>
                    <li><a href="#">Política de Privacidad</a></li>
                    <li><a href="#">Términos de Uso</a></li>
                </ul>
            </div>
        </div>
    </footer>
@endsection --}}

@section('forms-cruds')
@endsection

@section('scripts')
@endsection
