@extends('layouts.admin')

@section('title', 'Galería de Imágenes')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Imágenes</h3>
        <div class="card-actions">
            <a href="{{ route('gallery.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Subir Imagen
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="galleryTable" class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th width="100">Imagen</th>
                        <th>Título / Descripción</th>
                        <th>Categoría</th>
                        <th>Álbum Asociado</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galleries as $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $item->image_path) }}" class="rounded" style="width: 80px; height: 60px; object-fit: cover;">
                        </td>
                        <td>{{ $item->title ?? 'Sin título' }}</td>
                        <td>
                            <span class="badge bg-blue-lt">
                                @switch($item->category)
                                    @case('event') Evento @break
                                    @case('backstage') Backstage @break
                                    @case('artist') Artista @break
                                @endswitch
                            </span>
                        </td>
                        <td>{{ $item->album->title ?? '-' }}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('gallery.edit', $item) }}" class="btn btn-white btn-sm">Editar</a>
                                <form action="{{ route('gallery.destroy', $item) }}" method="POST">
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
        $('#galleryTable').DataTable();
    });
</script>
@endpush
