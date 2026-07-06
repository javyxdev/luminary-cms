@extends('layouts.admin')

@section('title', 'Dashboard Principal')

@section('content')
<div class="row row-deck row-cards">
    <div class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Eventos</div>
                </div>
                <div class="h1 mb-3">{{ $eventsCount }}</div>
                <div class="d-flex mb-2">
                    <div>Total de eventos registrados</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">DJs Aliados</div>
                </div>
                <div class="h1 mb-3">{{ $djsCount }}</div>
                <div class="d-flex mb-2">
                    <div>Artistas en la plataforma</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Galería</div>
                </div>
                <div class="h1 mb-3">{{ $galleryCount }}</div>
                <div class="d-flex mb-2">
                    <div>Imágenes publicadas</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bienvenido al Panel de Administración</h3>
            </div>
            <div class="card-body">
                <p>Desde este panel podrás gestionar todo el contenido de <strong>Luminary SV</strong> de forma rápida y sencilla. Utiliza el menú lateral para navegar entre las distintas secciones.</p>
                <ul>
                    <li><strong>Eventos:</strong> Crea y programa tus próximas fechas.</li>
                    <li><strong>DJs Aliados:</strong> Gestiona los perfiles y redes sociales de los artistas.</li>
                    <li><strong>Galería:</strong> Sube fotos de tus mejores momentos.</li>
                    <li><strong>Configuración:</strong> Cambia el logo, el Hero del home y otros parámetros globales.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
