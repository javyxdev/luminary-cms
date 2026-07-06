@extends('layouts.admin')

@section('title', 'Editar DJ Aliado')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3.41l3.42 -2.98z" /></svg>
                        Editar Perfil: {{ $dj->name }}
                    </h3>
                    <p class="card-subtitle">Actualiza los datos de contacto y la presencia digital del artista.</p>
                </div>
                <div class="card-actions">
                    <a href="{{ route('djs.index') }}" class="btn btn-white">Volver</a>
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

                <form action="{{ route('djs.update', $dj) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label required">Nombre Artístico</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $dj->name) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Biografía</label>
                        <textarea class="form-control" name="biography" rows="5" required>{{ old('biography', $dj->biography) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Actual</label>
                        <div class="mb-2">
                            <span class="avatar avatar-xl" style="background-image: url({{ asset('storage/' . $dj->image_path) }})"></span>
                        </div>
                        <label class="form-label">Cambiar Foto (Opcional)</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Facebook URL</label>
                            <input type="url" class="form-control" name="facebook_url" value="{{ old('facebook_url', $dj->facebook_url) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" class="form-control" name="instagram_url" value="{{ old('instagram_url', $dj->instagram_url) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SoundCloud URL</label>
                            <input type="url" class="form-control" name="soundcloud_url" value="{{ old('soundcloud_url', $dj->soundcloud_url) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Beatport URL</label>
                            <input type="url" class="form-control" name="beatport_url" value="{{ old('beatport_url', $dj->beatport_url) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">TikTok URL</label>
                            <input type="url" class="form-control" name="tiktok_url" value="{{ old('tiktok_url', $dj->tiktok_url) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Orden de Visualización</label>
                            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $dj->sort_order) }}">
                        </div>
                    </div>

                    <div class="card-footer text-end px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Actualizar Artista</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
