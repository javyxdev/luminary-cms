@extends('layouts.admin')

@section('title', 'Editar Álbum')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 20l2 2l4 -4" /><path d="M8.5 20h-3.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v7" /><path d="M4 8h16" /><path d="M4 12h12" /><path d="M4 16h10" /></svg>
                        Editar Álbum: {{ $album->title }}
                    </h3>
                    <p class="card-subtitle">Actualiza la portada, descripción o la vinculación con el evento.</p>
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

                <form action="{{ route('albums.update', $album) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label required">Título del Álbum</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $album->title) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description', $album->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vincular a Evento (Opcional)</label>
                            <select class="form-select" name="event_id">
                                <option value="">Independiente</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id', $album->event_id) == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Imagen de Portada Actual</label>
                            @if($album->cover_image_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $album->cover_image_path) }}" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control" name="cover_image">
                            <div class="form-hint">Dejar vacío para mantener la actual.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" {{ $album->is_active ? 'checked' : '' }}>
                            <span class="form-check-label">Álbum Activo</span>
                        </label>
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Actualizar Álbum</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
