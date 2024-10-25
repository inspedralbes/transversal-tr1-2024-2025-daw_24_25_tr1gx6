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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white">
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
            <button class="btn btn-primary" style="border-radius: 10px">Añadir</button>
        </div>
    </div>

    <div class="items" style="border: 2px solid blue">
        <div class="list-items">
            <ul>
                <li>Mio</li>
            </ul>
        </div>
    </div>  
</div>
@endsection

@section('forms-cruds')
@endsection

@section('scripts')
@endsection
