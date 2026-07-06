@extends('layouts.admin')

@section('title', 'Editar Evento')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                        Editar Evento: {{ $event->title }}
                    </h3>
                    <p class="card-subtitle">Modifica los detalles del evento o actualiza el estado de visibilidad.</p>
                </div>
                <div class="card-actions">
                    <a href="{{ route('events.index') }}" class="btn btn-white">Volver</a>
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

                <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label required">Título del Evento</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $event->title) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Descripción</label>
                        <textarea class="form-control" name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Fecha y Hora</label>
                            <input type="datetime-local" class="form-control" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Ubicación</label>
                            <input type="text" class="form-control" name="location" value="{{ old('location', $event->location) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Póster Actual</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="Póster" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                        <label class="form-label">Cambiar Póster (Opcional)</label>
                        <input type="file" class="form-control" name="image">
                        <div class="form-hint">Dejar vacío si no deseas cambiar la imagen actual.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Externo (Ticketera)</label>
                        <input type="url" class="form-control" name="external_link" value="{{ old('external_link', $event->external_link) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" {{ $event->is_active ? 'checked' : '' }}>
                            <span class="form-check-label">Evento Activo (Visible en la web)</span>
                        </label>
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Actualizar Evento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
