@extends('layouts.admin')

@section('title', 'Gestión de Eventos')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Eventos</h3>
        <div class="card-actions">
            <a href="{{ route('events.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Nuevo Evento
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>{{ session('success') }}</div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <div class="table-responsive">
            <table id="eventsTable" class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th width="80">Póster</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                        <td>
                            @if(!empty($event->image_path))
                            <span class="avatar avatar-md poster-preview" role="button"
                                  style="background-image: url({{ asset('storage/' . $event->image_path) }}); cursor: pointer;"
                                  data-image="{{ asset('storage/' . $event->image_path) }}"
                                  data-title="{{ $event->title }}"></span>
                            @else
                            <span class="avatar avatar-md"></span>
                            @endif
                        </td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->event_date->format('d/m/Y H:i') }}</td>
                        <td>{{ $event->location }}</td>
                        <td>
                            @if($event->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-white btn-sm">Editar</a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST">
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
        $('#eventsTable').DataTable({
            "order": []
        });

        // Vista previa del póster en modal al hacer click
        $(document).on('click', '.poster-preview', function() {
            Swal.fire({
                imageUrl: $(this).data('image'),
                imageAlt: $(this).data('title'),
                title: $(this).data('title'),
                showConfirmButton: false,
                showCloseButton: true,
                width: 'auto',
                background: '#ffffff'
            });
        });
    });
</script>
@endpush
