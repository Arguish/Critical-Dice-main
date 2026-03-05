@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
<h1>Editar Usuario: {{ $user->name }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group">
                <label for="name">Nombre *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Nueva Contraseña</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" name="password">
                <small class="form-text text-muted">Deja en blanco si no deseas cambiar la contraseña</small>
                @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control"
                    id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_admin" name="is_admin" value="1"
                        {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_admin">
                        <i class="fas fa-crown text-warning"></i> Usuario Administrador
                    </label>
                </div>
                <small class="form-text text-muted">
                    Los administradores tienen acceso completo al sistema
                </small>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Actualizar Usuario
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop