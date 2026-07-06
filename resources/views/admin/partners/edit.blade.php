@extends('layouts.admin')

@section('title', 'Editar Aliado')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Aliado: {{ $partner->name }}</h3>
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

                <form action="{{ route('partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label required">Nombre del Partner</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $partner->name) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción / Breve Reseña</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description', $partner->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Logotipo Actual</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $partner->logo_path) }}" class="img-thumbnail" style="max-height: 100px; background: #f4f4f4;">
                        </div>
                        <label class="form-label">Cambiar Logotipo (Opcional)</label>
                        <input type="file" class="form-control" name="logo">
                        <div class="form-hint">Dejar vacío para mantener el actual. Formatos: JPG, PNG, SVG, WebP.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL del Sitio Web</label>
                        <input type="url" class="form-control" name="website_url" value="{{ old('website_url', $partner->website_url) }}">
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Actualizar Aliado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
