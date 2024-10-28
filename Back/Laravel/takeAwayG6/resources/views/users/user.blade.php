@extends('Layout.master')

@section('content')

@foreach($users as $user)
<form action="{{ route('update.user', $user->id) }}" method="POST">
    @csrf
    <input type="text" value="{{ $user->name }}" name="name" required>
    <input type="text" value="{{ $user->email }}" name="email" required>
    <input type="text" value="{{ $user->password }}" name="password" required>
    <input type="text" value="{{ $user->rol }}" name="rol" required>
    <button type="submit">Actualiza</button>
</form>
<p>{{$user->name}}</p>
<p>{{$user->email}}</p>
<p>{{$user->password}}</p>
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
@endsection
@section('pages')
@endsection
@section('forms-cruds')
@endsection

@section('scripts')
@endsection