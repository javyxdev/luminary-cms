@extends('layouts.admin')

@section('title', 'Configuración Global')

@section('content')
<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" id="settings-tabs">
                        <a href="#tab-identity" class="list-group-item list-group-item-action active" data-bs-toggle="list">Identidad Visual</a>
                        <a href="#tab-hero" class="list-group-item list-group-item-action" data-bs-toggle="list">Hero del Home</a>
                        <a href="#tab-home" class="list-group-item list-group-item-action" data-bs-toggle="list">Secciones del Home</a>
                        <a href="#tab-contact" class="list-group-item list-group-item-action" data-bs-toggle="list">Contacto y Footer</a>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">
                <!-- Pestaña: Identidad -->
                <div class="tab-pane fade show active" id="tab-identity">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Identidad del Sitio</h3></div>
                        <div class="card-body">

                            {{-- Logo Sitio Web Público --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Logo del Sitio Web Público</label>
                                <div class="form-hint mb-2">Aparece en la cabecera (navbar) de todas las páginas del sitio público. Se recomienda PNG transparente o SVG.</div>
                                @if(!empty($settings['site_logo']))
                                <div class="mb-2 p-3 bg-dark rounded d-inline-block">
                                    <img src="{{ str_contains($settings['site_logo'], 'assets/') ? asset($settings['site_logo']) : asset('storage/' . $settings['site_logo']) }}"
                                         alt="Logo Sitio Público" style="height: 40px;">
                                </div>
                                @endif
                                <input type="file" class="form-control" name="site_logo" accept="image/*">
                            </div>

                            <hr>

                            {{-- Logo Panel Administrativo --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Logo del Panel Administrativo</label>
                                <div class="form-hint mb-2">Aparece en el sidebar del panel admin y en la pantalla de login de administrador.</div>
                                @if(!empty($settings['admin_logo']))
                                <div class="mb-2 p-3 bg-dark rounded d-inline-block">
                                    <img src="{{ str_contains($settings['admin_logo'], 'assets/') ? asset($settings['admin_logo']) : asset('storage/' . $settings['admin_logo']) }}"
                                         alt="Logo Admin" style="height: 40px;">
                                </div>
                                @endif
                                <input type="file" class="form-control" name="admin_logo" accept="image/*">
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Pestaña: Hero -->
                <div class="tab-pane fade" id="tab-hero">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Personalización del Hero (Banner Principal)</h3></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Título Principal</label>
                                <input type="text" class="form-control" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subtítulo</label>
                                <textarea class="form-control" name="hero_subtitle" rows="2">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Texto del Botón (CTA)</label>
                                    <input type="text" class="form-control" name="hero_cta_text" value="{{ $settings['hero_cta_text'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Enlace del Botón</label>
                                    <input type="text" class="form-control" name="hero_cta_link" value="{{ $settings['hero_cta_link'] ?? '' }}">
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">Tipo de Fondo del Hero</label>
                                <select class="form-select" name="hero_bg_type" id="hero_bg_type">
                                    <option value="image"         {{ ($settings['hero_bg_type'] ?? '') == 'image'         ? 'selected' : '' }}>Imagen Estática</option>
                                    <option value="slider"        {{ ($settings['hero_bg_type'] ?? '') == 'slider'        ? 'selected' : '' }}>Slider de Imágenes (hasta 4)</option>
                                    <option value="video_local"   {{ ($settings['hero_bg_type'] ?? '') == 'video_local'   ? 'selected' : '' }}>Video Local (Subido)</option>
                                    <option value="video_youtube" {{ ($settings['hero_bg_type'] ?? '') == 'video_youtube' ? 'selected' : '' }}>Video de YouTube (ID)</option>
                                </select>
                            </div>

                            <!-- Imagen Estática / Video Local -->
                            <div id="group-file" class="mb-3 hero-field {{ in_array($settings['hero_bg_type'] ?? '', ['video_youtube','slider']) ? 'd-none' : '' }}">
                                <label class="form-label" id="label-file">Subir Archivo de Fondo</label>
                                <input type="file" class="form-control" name="hero_bg_file">
                                @if(!empty($settings['hero_bg_path']))
                                    <div class="form-hint mt-2">
                                        Archivo actual: <a href="{{ asset('storage/' . $settings['hero_bg_path']) }}" target="_blank" class="text-primary">Ver fondo actual</a>
                                    </div>
                                @endif
                            </div>

                            <!-- YouTube -->
                            <div id="group-youtube" class="mb-3 hero-field {{ ($settings['hero_bg_type'] ?? '') != 'video_youtube' ? 'd-none' : '' }}">
                                <label class="form-label">YouTube Video ID</label>
                                <input type="text" class="form-control" name="hero_youtube_url" value="{{ $settings['hero_youtube_url'] ?? '' }}" placeholder="Ej: dQw4w9WgXcQ">
                                <div class="form-hint">Solo pega el ID del video (lo que sigue después de v= en la URL).</div>
                            </div>

                            <!-- Slider de Imágenes -->
                            <div id="group-slider" class="hero-field {{ ($settings['hero_bg_type'] ?? '') != 'slider' ? 'd-none' : '' }}">
                                <p class="form-label fw-bold mb-3">Imágenes del Slider <span class="text-muted fw-normal">(mínimo 2, máximo 4 — se recomienda misma proporción)</span></p>
                                @foreach([1,2,3,4] as $n)
                                @php $slideKey = "hero_slide_{$n}"; $current = $settings[$slideKey] ?? ''; @endphp
                                <div class="card mb-3 border-0 bg-light" id="slide-card-{{ $n }}">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="badge bg-dark text-white" style="font-size:.9rem; width:26px; height:26px; display:flex; align-items:center; justify-content:center;">{{ $n }}</span>
                                            </div>

                                            {{-- Estado: tiene imagen --}}
                                            <div class="col-auto slide-preview-{{ $n }}" style="{{ empty($current) ? 'display:none;' : '' }}">
                                                <img src="{{ !empty($current) ? asset('storage/' . $current) : '' }}"
                                                     id="slide-thumb-{{ $n }}"
                                                     style="height:56px; width:100px; object-fit:cover; border-radius:4px;">
                                            </div>
                                            <div class="col slide-has-image-{{ $n }}" style="{{ empty($current) ? 'display:none;' : '' }}">
                                                <div class="text-muted small mb-1">Imagen activa. Puedes reemplazarla subiendo una nueva.</div>
                                                <input type="file" class="form-control form-control-sm" name="{{ $slideKey }}" accept="image/*">
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger mt-2 slide-delete-btn"
                                                        data-key="{{ $slideKey }}"
                                                        data-n="{{ $n }}"
                                                        data-url="{{ route('settings.slide.delete', $slideKey) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-right:4px; vertical-align:-2px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Eliminar imagen
                                                </button>
                                            </div>

                                            {{-- Estado: sin imagen --}}
                                            <div class="col slide-no-image-{{ $n }}" style="{{ !empty($current) ? 'display:none;' : '' }}">
                                                <input type="file" class="form-control form-control-sm" name="{{ $slideKey }}" accept="image/*">
                                                <div class="form-hint">Sin imagen — opcional</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña: Secciones del Home -->
                <div class="tab-pane fade" id="tab-home">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Secciones del Home</h3></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Imagen — Sección "Nuestra Historia"</label>
                                <div class="form-hint mb-2">
                                    Foto que aparece en el recuadro derecho de la sección de historia en la página principal.
                                    Se recomienda una imagen vertical u horizontal de alta calidad.
                                </div>
                                @if(!empty($settings['home_about_image']))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $settings['home_about_image']) }}"
                                         alt="Imagen Historia" class="rounded" style="max-height: 200px;">
                                </div>
                                @endif
                                <input type="file" class="form-control" name="home_about_image" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña: Contacto -->
                <div class="tab-pane fade" id="tab-contact">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Información Global y Footer</h3></div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Email de Contacto</label>
                                <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Facebook URL</label>
                                <input type="url" class="form-control" name="footer_facebook" value="{{ $settings['footer_facebook'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Instagram URL</label>
                                <input type="url" class="form-control" name="footer_instagram" value="{{ $settings['footer_instagram'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TikTok URL</label>
                                <input type="url" class="form-control" name="footer_tiktok" value="{{ $settings['footer_tiktok'] ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Texto Copyright (Footer)</label>
                                <input type="text" class="form-control" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Lógica dinámica para los campos del Hero
        function updateHeroFields(type) {
            $('.hero-field').addClass('d-none');
            if (type === 'image' || type === 'video_local') {
                $('#group-file').removeClass('d-none');
                $('#label-file').text(type === 'image' ? 'Subir Imagen de Fondo' : 'Subir Video Local (MP4/WebM)');
            } else if (type === 'video_youtube') {
                $('#group-youtube').removeClass('d-none');
            } else if (type === 'slider') {
                $('#group-slider').removeClass('d-none');
            }
        }

        $('#hero_bg_type').on('change', function() {
            updateHeroFields($(this).val());
        });

        // Eliminación asíncrona de slides
        $(document).on('click', '.slide-delete-btn', function() {
            const btn  = $(this);
            const key  = btn.data('key');
            const n    = btn.data('n');
            const url  = btn.data('url');

            Swal.fire({
                title: '¿Eliminar imagen?',
                text: 'Se eliminará el archivo del servidor de forma inmediata.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
            }).then((result) => {
                if (!result.isConfirmed) return;

                btn.prop('disabled', true).text('Eliminando...');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                    success: function() {
                        // Ocultar estado "con imagen", mostrar estado "sin imagen"
                        $(`.slide-preview-${n}`).hide();
                        $(`.slide-has-image-${n}`).hide();
                        $(`.slide-no-image-${n}`).show();

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: `Slide ${n} eliminado`,
                            showConfirmButton: false,
                            timer: 2500,
                        });
                    },
                    error: function() {
                        btn.prop('disabled', false).text('Eliminar imagen');
                        Swal.fire('Error', 'No se pudo eliminar la imagen.', 'error');
                    }
                });
            });
        });
    });
</script>
@endpush
