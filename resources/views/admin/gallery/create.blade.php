@extends('layouts.admin')

@section('title', 'Añadir a Galería')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01" /><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" /><path d="M13 13l1 -1c.928 -.893 2.072 -.893 3 0l3 3" /></svg>
                        Añadir a Galería
                    </h3>
                    <p class="card-subtitle">Sube una nueva fotografía y asígnala a un álbum para su publicación.</p>
                </div>
                <div class="card-actions">
                    <a href="{{ route('gallery.index') }}" class="btn btn-white">Volver</a>
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

                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Título / Pie de Foto (Opcional)</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Ej: Momentos del evento...">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Seleccionar Álbum</label>
                            <select class="form-select" name="album_id" required>
                                <option value="" selected disabled>Seleccione un álbum...</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Categoría</label>
                            <select class="form-select" name="category" required>
                                <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Evento</option>
                                <option value="backstage" {{ old('category') == 'backstage' ? 'selected' : '' }}>Backstage</option>
                                <option value="artist" {{ old('category') == 'artist' ? 'selected' : '' }}>Artista</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Imagen</label>
                        <input type="file" class="form-control" name="image" required>
                        <div class="form-hint">Formatos soportados: JPG, PNG, WebP. Máximo 3MB.</div>
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Subir Imagen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
