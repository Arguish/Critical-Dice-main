@extends('adminlte::page')

@section('title', 'Detalles del Usuario')

@section('content_header')
<h1>Detalles del Usuario</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="{{ $user->profile_photo_url }}"
                        alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                <p class="text-muted text-center">
                    @if($user->is_admin)
                    <span class="badge badge-danger">
                        <i class="fas fa-crown"></i> Administrador
                    </span>
                    @else
                    <span class="badge badge-primary">
                        <i class="fas fa-user"></i> Usuario
                    </span>
                    @endif
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Personajes</b> <a class="float-right">{{ $user->characters->count() }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Registro</b> <a class="float-right">{{ $user->created_at->format('d/m/Y') }}</a>
                    </li>
                </ul>

                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Editar Usuario
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users"></i> Personajes del Usuario
                </h3>
            </div>
            <div class="card-body p-0">
                @if($user->characters->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Raza</th>
                            <th>Clase</th>
                            <th>Sistema</th>
                            <th>Creado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->characters as $character)
                        <tr>
                            <td>{{ $character->character_name }}</td>
                            <td>{{ $character->race }}</td>
                            <td>{{ $character->class }}</td>
                            <td>
                                <span class="badge badge-info">{{ strtoupper($character->system) }}</span>
                            </td>
                            <td>{{ $character->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center p-4">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Este usuario no tiene personajes creados</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="{{ route('admin.users.index') }}" class="btn btn-default">
            <i class="fas fa-arrow-left"></i> Volver a la Lista
        </a>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop