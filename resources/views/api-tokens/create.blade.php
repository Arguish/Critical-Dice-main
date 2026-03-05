@extends('adminlte::page')

@section('title', 'Crear API Token')

@section('content_header')
<h1><i class="fas fa-plus-circle"></i> Crear Nuevo API Token</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-success card-outline">
            <div class="card-header with-border">
                <h3 class="card-title"><i class="fas fa-key"></i> Nuevo Token</h3>
            </div>

            <form action="{{ route('api-tokens.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label for="name"><strong>Nombre del Token</strong></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" placeholder="ej: Postman Testing"
                            value="{{ old('name') }}" required>
                        @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="callout callout-warning">
                        <h5><i class="fas fa-exclamation-triangle"></i> Importante</h5>
                        <p class="mb-0">El token solo aparecerá una vez después de crearlo. <strong>Cópialo inmediatamente</strong> y guárdalo en un lugar seguro.</p>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Crear Token
                    </button>
                    <a href="{{ route('api-tokens.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-info card-outline">
            <div class="card-header with-border">
                <h3 class="card-title"><i class="fas fa-question-circle"></i> ¿Para qué sirve?</h3>
            </div>
            <div class="card-body">
                <p><strong>Los API Tokens te permiten acceder a la API desde:</strong></p>
                <ul>
                    <li><i class="fas fa-check text-success"></i> Postman</li>
                    <li><i class="fas fa-check text-success"></i> Thunder Client</li>
                    <li><i class="fas fa-check text-success"></i> Aplicaciones externas</li>
                    <li><i class="fas fa-check text-success"></i> Scripts y cURL</li>
                </ul>

                <hr>

                <h5 class="font-weight-bold">Endpoint principal</h5>
                <div class="callout callout-primary" style="padding: 10px; margin: 0;">
                    <code>/api/v1/characters</code>
                </div>

                <h5 class="font-weight-bold mt-3">Autenticación</h5>
                <div class="callout callout-success" style="padding: 10px; margin: 0;">
                    <code>Bearer {token}</code>
                </div>
            </div>
        </div>
    </div>
</div>
@stop