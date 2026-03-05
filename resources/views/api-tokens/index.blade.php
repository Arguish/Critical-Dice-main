@extends('adminlte::page')

@section('title', 'API Tokens')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>API Tokens</h1>
    </div>
    <div class="col-sm-6 text-right">
        <a href="{{ route('api-tokens.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Nuevo Token
        </a>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="alert-heading"><i class="fas fa-check-circle"></i> ¡Éxito!</h4>
            {{ $message }}
        </div>
        @endif

        <div class="card card-outline card-success">
            <div class="card-header with-border">
                <h3 class="card-title"><i class="fas fa-key"></i> Tus API Tokens</h3>
            </div>
            <div class="card-body">
                @forelse ($tokens as $token)
                <div class="card card-outline card-primary mb-3" style="border-top-width: 3px;">
                    <div class="card-body pt-2 pb-2">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="mb-1">
                                    <i class="fas fa-lock text-warning"></i>
                                    <strong>{{ $token->name }}</strong>
                                </h5>
                                <p class="text-muted mb-0 small">
                                    <i class="far fa-calendar"></i>
                                    Creado: {{ $token->created_at->format('d/m/Y \a \l\a\s H:i') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <form action="{{ route('api-tokens.destroy', $token->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este token?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="callout callout-warning">
                    <h5><i class="fas fa-info-circle"></i> Sin tokens</h5>
                    <p class="mb-0">No tienes tokens aún. <a href="{{ route('api-tokens.create') }}" class="font-weight-bold">Crea uno aquí</a> para acceder a la API.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-outline card-warning">
            <div class="card-header with-border">
                <h3 class="card-title"><i class="fas fa-book"></i> Cómo usar</h3>
            </div>
            <div class="card-body small">
                <h6 class="text-uppercase font-weight-bold">Postman</h6>
                <div class="callout callout-info" style="padding: 8px; margin: 5px 0;">
                    <code style="font-size: 11px; word-break: break-all;">Authorization: Bearer {token}</code>
                </div>

                <h6 class="text-uppercase font-weight-bold mt-2">Thunder Client</h6>
                <div class="callout callout-info" style="padding: 8px; margin: 5px 0;">
                    <code style="font-size: 11px; word-break: break-all;">Auth: Bearer Token</code>
                </div>

                <h6 class="text-uppercase font-weight-bold mt-2">cURL</h6>
                <div class="callout callout-info" style="padding: 8px; margin: 5px 0;">
                    <code style="font-size: 11px; word-break: break-all;">-H "Authorization: Bearer {token}"</code>
                </div>
            </div>
        </div>

        <div class="card card-outline card-info">
            <div class="card-header with-border">
                <h3 class="card-title"><i class="fas fa-plug"></i> Base URL</h3>
            </div>
            <div class="card-body">
                <div class="callout callout-success" style="padding: 10px; margin: 0;">
                    <code style="font-size: 12px;">http://localhost:8000/api/v1</code>
                </div>
            </div>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-header with-border">
                <h3 class="card-title"><i class="fas fa-code"></i> Endpoints</h3>
            </div>
            <div class="card-body small">
                <ul class="list-unstyled">
                    <li><span class="badge badge-success">GET</span> <code>/characters</code></li>
                    <li><span class="badge badge-info">POST</span> <code>/characters</code></li>
                    <li><span class="badge badge-warning">GET</span> <code>/characters/{id}</code></li>
                    <li><span class="badge badge-warning">PATCH</span> <code>/characters/{id}</code></li>
                    <li><span class="badge badge-danger">DELETE</span> <code>/characters/{id}</code></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop