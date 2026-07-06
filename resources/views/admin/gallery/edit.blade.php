@extends('layouts.admin')

@section('title', 'Editar Imagen de Galería')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01" /><path d="M12 20h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v7" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3 3" /><path d="M14 14l1 -1c.67 -.644 1.45 -.824 2.182 -.54" /><path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3.41l3.42 -2.98z" /></svg>
                        Editar Imagen
                    </h3>
                    <p class="card-subtitle">Actualiza el pie de foto, la categoría o el álbum correspondiente.</p>
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

                <form action="{{ route('gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Título / Pie de Foto (Opcional)</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $gallery->title) }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Álbum Asociado</label>
                            <select class="form-select" name="album_id" required>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}" {{ old('album_id', $gallery->album_id) == $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Categoría</label>
                            <select class="form-select" name="category" required>
                                <option value="event" {{ old('category', $gallery->category) == 'event' ? 'selected' : '' }}>Evento</option>
                                <option value="backstage" {{ old('category', $gallery->category) == 'backstage' ? 'selected' : '' }}>Backstage</option>
                                <option value="artist" {{ old('category', $gallery->category) == 'artist' ? 'selected' : '' }}>Artista</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagen Actual</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                        <label class="form-label">Reemplazar Imagen (Opcional)</label>
                        <input type="file" class="form-control" name="image">
                        <div class="form-hint">Dejar vacío para mantener la actual. Máximo 3MB.</div>
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Actualizar Imagen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
