@extends('layouts.admin')

@section('title', 'Gestionar Sobre Nosotros')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <form action="{{ route('about.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contenido Narrativo de Luminary SV</h3>
                    <div class="card-actions">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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

                    <div class="mb-3">
                        <label class="form-label required">Título de la Sección</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $aboutUs->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Nuestra Historia / Contenido Principal</label>
                        <textarea class="form-control" name="content" rows="10" placeholder="Escribe aquí la historia de la marca..." required>{{ old('content', $aboutUs->content) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nuestra Misión</label>
                            <textarea class="form-control" name="mission" rows="4">{{ old('mission', $aboutUs->mission) }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nuestra Visión</label>
                            <textarea class="form-control" name="vision" rows="4">{{ old('vision', $aboutUs->vision) }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagen de Cabecera (Sección Sobre Nosotros)</label>
                        @if($aboutUs->hero_image_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $aboutUs->hero_image_path) }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" class="form-control" name="hero_image">
                        <div class="form-hint">Dejar vacío para mantener la actual. Formatos: JPG, PNG, WebP.</div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Actualizar Información</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
