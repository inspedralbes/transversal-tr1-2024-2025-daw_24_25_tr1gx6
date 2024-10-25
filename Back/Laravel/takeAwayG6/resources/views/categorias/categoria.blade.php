@extends('Layout.master')

@section('content')
    <h1>CRUD de Categorías</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->nom }}</td>
                    <td>
                        <form action="{{ route('delete.category', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Eliminar</button>
                        </form>

                        <form action="{{ route('update.category', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="text" name="nom" value="{{ $category->nom }}" required>
                            <input type="text" name="imagen" value="{{ $category->imagen }}" required>
                            <button type="submit">Actualizar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <h2>Crear Nueva Categoría</h2>
            </tbody>
        </table>
        <form action="{{ route('create.category') }}" method="POST">
            @csrf
            <label for="nom">Nombre de la Categoría:</label>
            <input type="text" name="nom" required>
            <input type="text" name="imagen" required>
            <button type="submit">Crear Categoría</button>
        </form>
@endsection 

@section('forms-cruds')
@endsection
