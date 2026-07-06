@extends('layouts.admin')

@section('title', 'Álbumes de Galería')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Álbumes</h3>
        <div class="card-actions">
            <a href="{{ route('albums.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Nuevo Álbum
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="albumsTable" class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th width="80">Portada</th>
                        <th>Título</th>
                        <th>Evento</th>
                        <th>Estado</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($albums as $album)
                    <tr>
                        <td>
                            @if($album->cover_image_path)
                                <img src="{{ asset('storage/' . $album->cover_image_path) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <span class="avatar avatar-md">?</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $album->title }}</div>
                            <div class="text-muted small">{{ Str::limit($album->description, 50) }}</div>
                        </td>
                        <td>{{ $album->event->title ?? 'Independiente' }}</td>
                        <td>
                            @if($album->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('albums.edit', $album) }}" class="btn btn-white btn-sm">Editar</a>
                                <form action="{{ route('albums.destroy', $album) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#albumsTable').DataTable();
    });
</script>
@endpush
