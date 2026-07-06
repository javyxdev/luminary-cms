@extends('layouts.admin')

@section('title', 'Nuevo Aliado')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información de la Alianza</h3>
                <div class="card-actions">
                    <a href="{{ route('partners.index') }}" class="btn btn-white">Volver</a>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label required">Nombre del Partner</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Ej: Urban Alien" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción / Breve Reseña</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Cuéntanos un poco sobre este aliado...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Logotipo</label>
                        <input type="file" class="form-control" name="logo" required>
                        <div class="form-hint">Formatos soportados: JPG, PNG, SVG, WebP. Recomendado fondo transparente.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL del Sitio Web</label>
                        <input type="url" class="form-control" name="website_url" value="{{ old('website_url') }}" placeholder="https://www.urbanalien.com">
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Guardar Aliado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
