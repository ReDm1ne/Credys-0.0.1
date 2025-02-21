@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Empleado</h1>
    <form action="{{ route('empleados.update', $empleado) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $empleado->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $empleado->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña (Deja en blanco para mantener la actual)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="sucursal_id">Sucursal</label>
            <select name="sucursal_id" id="sucursal_id" class="form-control" required>
                @foreach(\App\Models\Sucursal::all() as $sucursal)
                    <option value="{{ $sucursal->id }}" @if($empleado->sucursal_id == $sucursal->id) selected @endif>
                        {{ $sucursal->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="role_id">Rol</label>
            <select name="role_id" id="role_id" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if($empleado->role_id == $role->id) selected @endif>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection