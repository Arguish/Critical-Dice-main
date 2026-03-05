@extends('adminlte::page')

@section('title', 'Tu API Token')

@section('content_header')
<h1><i class="fas fa-key"></i> Token Generado Exitosamente</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-success card-outline">
            <div class="card-header with-border">
                <h3 class="card-title"><i class="fas fa-check-circle"></i> Listo para usar</h3>
            </div>

            <div class="card-body">
                <div class="callout callout-danger">
                    <h4><i class="fas fa-exclamation-circle"></i> Ojo importante</h4>
                    <p class="mb-0"><strong>Este es el único lugar donde verás tu token completo.</strong> Cópialo ahora y guárdalo en un lugar seguro. No podrás recuperarlo después.</p>
                </div>

                <div class="callout callout-info">
                    <h5><i class="fas fa-tag"></i> Nombre del Token</h5>
                    <code>{{ $name }}</code>
                </div>

                <div class="form-group">
                    <label for="tokenInput"><strong>Tu Token:</strong></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="tokenInput"
                            value="{{ $token }}" readonly
                            style="font-family: 'Courier New', monospace; font-size: 12px;">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="copyBtn"
                                data-toggle="tooltip" title="Copiar token al portapapeles">
                                <i class="fas fa-copy"></i> Copiar
                            </button>
                        </div>
                    </div>
                </div>

                <hr>

                <h4 class="font-weight-bold text-uppercase"><i class="fas fa-book"></i> Cómo usarlo</h4>

                <h5 class="font-weight-bold mt-3">Postman</h5>
                <div class="callout callout-info" style="padding: 10px;">
                    <code style="font-size: 12px;">Authorization: Bearer {{ substr($token, 0, 25) }}...</code>
                </div>

                <h5 class="font-weight-bold mt-3">Thunder Client</h5>
                <div class="callout callout-info" style="padding: 10px;">
                    <code style="font-size: 12px;">Auth Type: Bearer Token<br>Token: {{ substr($token, 0, 25) }}...</code>
                </div>

                <h5 class="font-weight-bold mt-3">cURL</h5>
                <div class="callout callout-info" style="padding: 10px;">
                    <code style="font-size: 11px;">-H "Authorization: Bearer {{ substr($token, 0, 25) }}..."</code>
                </div>

                <hr>

                <div class="callout callout-success">
                    <h5><i class="fas fa-link"></i> Base URL API</h5>
                    <code>http://localhost:8000/api/v1</code>
                </div>

                <div class="callout callout-info">
                    <h5><i class="fas fa-code"></i> Endpoints disponibles</h5>
                    <ul class="list-unstyled mb-0">
                        <li><span class="badge badge-success">GET</span> <code>/characters</code></li>
                        <li><span class="badge badge-info">POST</span> <code>/characters</code></li>
                        <li><span class="badge badge-warning">GET</span> <code>/characters/{id}</code></li>
                        <li><span class="badge badge-warning">PATCH</span> <code>/characters/{id}</code></li>
                        <li><span class="badge badge-danger">DELETE</span> <code>/characters/{id}</code></li>
                    </ul>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('api-tokens.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Volver a Tokens
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });

    document.getElementById('copyBtn').addEventListener('click', function() {
        const input = document.getElementById('tokenInput');
        input.select();
        input.setSelectionRange(0, 99999);
        document.execCommand('copy');

        const btn = this;
        const originalHTML = btn.innerHTML;
        const originalClass = btn.className;

        btn.innerHTML = '<i class="fas fa-check"></i> ¡Copiado!';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-info');

        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.className = originalClass;
        }, 2000);
    });
</script>
@stop