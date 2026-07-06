@extends('layouts.admin')

@section('title', 'Nuevo Evento')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M7 7v-2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v2" /><path d="M11 3l2 2l-2 2" /><path d="M10 13h4" /><path d="M10 17h4" /></svg>
                        Crear Nuevo Evento
                    </h3>
                    <p class="card-subtitle">Configura la fecha, el lugar y el póster oficial para la cartelera pública.</p>
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

                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label required">Título del Evento</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Ej: Trance Haven Vol. 1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Descripción</label>
                        <textarea class="form-control" name="description" rows="5" placeholder="Detalles del evento..." required>{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Fecha y Hora</label>
                            <input type="datetime-local" class="form-control" name="event_date" value="{{ old('event_date') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Ubicación</label>
                            <input type="text" class="form-control" name="location" value="{{ old('location') }}" placeholder="Ej: Musiklub" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Póster del Evento</label>
                        <input type="file" class="form-control" name="image" required>
                        <div class="form-hint">Recomendado: 1080x1350px (Formato vertical para redes)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Externo (Ticketera)</label>
                        <input type="url" class="form-control" name="external_link" value="{{ old('external_link') }}" placeholder="https://eventbrite.com/...">
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <span class="form-check-label">Publicar inmediatamente</span>
                        </label>
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Crear Evento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
