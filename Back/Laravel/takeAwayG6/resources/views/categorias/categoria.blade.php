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
                        <!-- Formulario para eliminar -->
                        <form action="{{ route('delete.category', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Eliminar</button>
                        </form>

                        <!-- Formulario para actualizar -->
                        <form action="{{ route('update.category', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="text" name="nom" value="{{ $category->nom }}" required>
                            <button type="submit">Actualizar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection 

@section('forms-cruds')
    <h2>Crear Nueva Categoría</h2>
    <form action="{{ route('create.category') }}" method="POST">
        @csrf
        <label for="nom">Nombre de la Categoría:</label>
        <input type="text" name="nom" required>
        <button type="submit">Crear Categoría</button>
    </form>
@endsection
