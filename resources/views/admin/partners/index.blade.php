@extends('layouts.admin')

@section('title', 'Alianzas y Partners')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Aliados</h3>
        <div class="card-actions">
            <a href="{{ route('partners.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Nuevo Aliado
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="partnersTable" class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th width="100">Logo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Sitio Web</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partners as $partner)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $partner->logo_path) }}" class="rounded" style="width: 80px; height: 40px; object-fit: contain; background: #f4f4f4;">
                        </td>
                        <td>{{ $partner->name }}</td>
                        <td>{{ Str::limit($partner->description, 50) }}</td>
                        <td>
                            @if($partner->website_url)
                                <a href="{{ $partner->website_url }}" target="_blank" class="link-primary">Ver sitio</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('partners.edit', $partner) }}" class="btn btn-white btn-sm">Editar</a>
                                <form action="{{ route('partners.destroy', $partner) }}" method="POST">
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
        $('#partnersTable').DataTable();
    });
</script>
@endpush
