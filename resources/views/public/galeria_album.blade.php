@extends('layouts.public')

@section('title', $album->title . ' — Galería Luminary')
@section('description', $album->description ?? 'Fotos del álbum ' . $album->title . ' de Luminary.')

@section('content')

{{-- Page Header --}}
<div class="lmn-bg-navy py-15 text-center">

    {{-- Breadcrumb --}}
    <div class="flex items-center justify-center gap-2 mb-4 text-xs tracking-widest uppercase" style="color: rgba(255,255,255,0.3);">
        <a href="{{ route('galeria') }}" class="hover:text-white transition-colors" style="color: rgba(255,255,255,0.3);">Galería</a>
        <span>/</span>
        <span style="color: var(--lmn-cyan);">{{ $album->title }}</span>
    </div>

    <h1 class="font-display font-black uppercase text-white" style="font-size: clamp(2.5rem, 7vw, 5rem);">
        {{ strtoupper($album->title) }}
    </h1>

    <p class="text-white/50 pb-5 text-base mt-2">
        @if($album->event)
            {{ $album->event->title }} · {{ $album->event->event_date->format('d M Y') }} ·
        @endif
        {{ $album->gallery->count() }} {{ $album->gallery->count() === 1 ? 'foto' : 'fotos' }}
    </p>
</div>

<div class="h-1 w-full" style="background: linear-gradient(to right, transparent, var(--lmn-cyan), transparent);"></div>

{{-- Photos Grid --}}
@php
    $photos = $album->gallery;
    // Serializar para Alpine.js
    $photosJson = $photos->map(fn($p) => [
        'src'   => asset('storage/' . $p->image_path),
        'title' => $p->title ?? $album->title,
    ])->values()->toJson();
@endphp

<section class="py-20 lmn-bg-dark" x-data="albumLightbox({{ $photosJson }})">

    @if($photos->isEmpty())
    <div class="text-center py-24 max-w-7xl mx-auto px-5">
        <p class="font-display text-3xl text-white/30 uppercase tracking-widest">Álbum sin fotos</p>
        <a href="{{ route('galeria') }}" class="inline-block mt-6 text-sm tracking-widest uppercase" style="color: var(--lmn-cyan);">← Volver a la galería</a>
    </div>
    @else

    <div class="max-w-7xl mx-auto px-5">

        {{-- Grid de fotos --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($photos as $i => $photo)
            <div class="overflow-hidden rounded-lg cursor-pointer group relative"
                 @click="open({{ $i }})">
                <img src="{{ asset('storage/' . $photo->image_path) }}"
                     alt="{{ $photo->title ?? $album->title }}"
                     class="w-full object-cover transition-transform duration-300 group-hover:scale-105"
                     style="aspect-ratio: 1/1;">
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg"
                     style="background: rgba(0,0,0,0.35);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: rgba(255,255,255,0.9);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Volver --}}
        <div class="mt-14 text-center">
            <a href="{{ route('galeria') }}" class="lmn-btn lmn-btn-outline text-sm" style="color:rgba(255,255,255,0.6); border-color:rgba(255,255,255,0.2);">
                ← Volver a la galería
            </a>
        </div>

    </div>

    {{-- ─── Lightbox ─── --}}
    <div x-show="active"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="close()"
         @keydown.escape.window="close()"
         @keydown.arrow-left.window="prev()"
         @keydown.arrow-right.window="next()"
         class="fixed inset-0 flex items-center justify-center"
         style="z-index: 200; background: rgba(0,0,0,0.92);">

        {{-- Cerrar --}}
        <button @click="close()"
                class="absolute top-5 right-6 text-white/50 hover:text-white transition-colors"
                style="font-size: 2rem; line-height: 1; background: none; border: none; cursor: pointer;"
                aria-label="Cerrar">&times;</button>

        {{-- Contador --}}
        <div class="absolute top-5 left-1/2 -translate-x-1/2 text-xs tracking-widest uppercase"
             style="color: rgba(255,255,255,0.35);">
            <span x-text="current + 1"></span> / <span x-text="photos.length"></span>
        </div>

        {{-- Flecha izquierda --}}
        <button @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center justify-center rounded-full transition-all"
                style="z-index:10; width:48px; height:48px; background:rgba(0,0,0,0.45); border:1px solid rgba(6,182,212,0.35); color:rgba(255,255,255,0.75); cursor:pointer;"
                onmouseover="this.style.background='rgba(6,182,212,0.2)'" onmouseout="this.style.background='rgba(0,0,0,0.45)'"
                aria-label="Anterior">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Imagen --}}
        <div class="flex items-center justify-center px-20" style="max-width:90vw; max-height:85vh;">
            <img :src="photos[current]?.src"
                 :alt="photos[current]?.title"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="rounded-lg shadow-2xl object-contain"
                 style="max-width:100%; max-height:85vh;">
        </div>

        {{-- Flecha derecha --}}
        <button @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center rounded-full transition-all"
                style="z-index:10; width:48px; height:48px; background:rgba(0,0,0,0.45); border:1px solid rgba(6,182,212,0.35); color:rgba(255,255,255,0.75); cursor:pointer;"
                onmouseover="this.style.background='rgba(6,182,212,0.2)'" onmouseout="this.style.background='rgba(0,0,0,0.45)'"
                aria-label="Siguiente">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Título de la foto --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-center px-4">
            <p class="text-white/50 text-sm tracking-wide" x-text="photos[current]?.title"></p>
        </div>

        {{-- Dots --}}
        @if($photos->count() <= 20)
        <div class="absolute flex gap-1.5" style="bottom: 2.5rem; left:50%; transform:translateX(-50%);">
            @foreach($photos as $i => $p)
            <button @click="current = {{ $i }}"
                    :style="{{ $i }} === current ? 'background:rgba(6,182,212,0.9); width:20px;' : 'background:rgba(255,255,255,0.25); width:8px;'"
                    style="height:8px; border-radius:4px; border:none; padding:0; transition:all .3s; cursor:pointer;"></button>
            @endforeach
        </div>
        @endif

    </div>

    @endif
</section>

@endsection

@push('scripts')
<script>
function albumLightbox(photos) {
    return {
        photos: photos,
        current: 0,
        active: false,
        open(index) {
            this.current = index;
            this.active  = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.active = false;
            document.body.style.overflow = '';
        },
        prev() {
            if (!this.active) return;
            this.current = (this.current - 1 + this.photos.length) % this.photos.length;
        },
        next() {
            if (!this.active) return;
            this.current = (this.current + 1) % this.photos.length;
        },
    };
}
</script>
@endpush
