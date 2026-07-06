@extends('layouts.admin')

@section('title', 'Nuevo Álbum')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M4 8h16" /><path d="M4 12h16" /><path d="M4 16h16" /></svg>
                        Nuevo Álbum de Fotos
                    </h3>
                    <p class="card-subtitle">Crea un contenedor temático para organizar las imágenes de la galería.</p>
                </div>
                <div class="card-actions">
                    <a href="{{ route('albums.index') }}" class="btn btn-white">Volver</a>
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

                <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label required">Título del Álbum</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Ej: Gira Verano 2026" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Breve reseña del álbum...">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vincular a Evento (Opcional)</label>
                            <select class="form-select" name="event_id">
                                <option value="">Independiente</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Imagen de Portada</label>
                            <input type="file" class="form-control" name="cover_image">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <span class="form-check-label">Álbum Activo</span>
                        </label>
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Crear Álbum</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
