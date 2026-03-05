@extends('adminlte::page')

@section('title', 'Dashboard - Critical Dice')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bienvenido, {{ auth()->user()->name }}</h3>
            </div>
            <div class="card-body">
                @if(auth()->user()->is_admin)
                {{-- Contenido para administradores --}}
                <div class="alert alert-info">
                    <i class="fas fa-crown"></i> Panel de Administrador
                </div>

                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ \App\Models\User::count() }}</h3>
                                <p>Usuarios Totales</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                                Gestionar usuarios <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ \App\Models\Character::count() }}</h3>
                                <p>Personajes Totales</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dice-d20"></i>
                            </div>
                            <a href="{{ route('characters.index') }}" class="small-box-footer">
                                Ver todos <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ \App\Models\User::where('is_admin', true)->count() }}</h3>
                                <p>Administradores</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                                Ver detalles <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @else
                {{-- Contenido para usuarios normales --}}
                <div class="alert alert-success">
                    <i class="fas fa-dice-d20"></i> Panel de Usuario
                </div>

                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ auth()->user()->characters()->count() }}</h3>
                                <p>Mis Personajes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ route('characters.index') }}" class="small-box-footer">
                                Ver personajes <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>Crear</h3>
                                <p>Nuevo Personaje</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <a href="{{ route('character.selector') }}" class="small-box-footer">
                                Ir al creador <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>API</h3>
                                <p>Mi Token</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <a href="{{ route('api-tokens.index') }}" class="small-box-footer">
                                Gestionar tokens <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Lista de personajes del usuario --}}
                @if(auth()->user()->characters()->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i> Tus Últimos Personajes
                        </h3>
                    </div>
                    <div class="card-body p-0">
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
                                @foreach(auth()->user()->characters()->latest()->take(5)->get() as $character)
                                <tr>
                                    <td><strong>{{ $character->character_name }}</strong></td>
                                    <td>{{ $character->race }}</td>
                                    <td>{{ $character->class }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ strtoupper($character->system) }}</span>
                                    </td>
                                    <td>{{ $character->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
{{-- Estilos personalizados de Critical Dice --}}
<link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop

@section('js')
<script>
    console.log('Dashboard de Critical Dice cargado');
</script>
@stop