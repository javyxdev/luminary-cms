@extends('layouts.public')

@section('title', 'Galería — Luminary')
@section('description', 'Revive los mejores momentos de los eventos de Luminary.')

@section('content')

{{-- Page Header --}}
<div class="lmn-bg-navy py-10 md:py-16 text-center">
    <h1 class="font-display font-black uppercase text-white" style="font-size: clamp(3rem, 8vw, 6rem);">
        GALERÍA <span class="lmn-text-cyan">LMNRY</span>
    </h1>
    <p class="text-white/50 pb-5 text-base">Revive los mejores momentos de nuestros eventos.</p>
</div>

<div class="h-1 w-full" style="background: linear-gradient(to right, transparent, var(--lmn-cyan), transparent);"></div>

{{-- Albums Grid --}}
<section class="py-20 lmn-bg-dark">
    <div class="max-w-7xl mx-auto px-5">

        @if($albums->isEmpty())
        <div class="text-center py-24">
            <p class="font-display text-3xl text-white/30 uppercase tracking-widest">Sin álbumes disponibles</p>
            <p class="text-white/20 mt-3 text-sm">Vuelve pronto para ver las fotos de nuestros eventos.</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($albums as $album)
            @php
                $cover = $album->cover_image_path
                    ? asset('storage/' . $album->cover_image_path)
                    : ($album->gallery->first()?->image_path
                        ? asset('storage/' . $album->gallery->first()->image_path)
                        : null);
            @endphp

            <a href="{{ route('galeria.album', $album->slug) }}"
               class="group block lmn-card rounded-xl overflow-hidden transition-transform duration-300 hover:-translate-y-1">

                {{-- Cover --}}
                <div class="relative overflow-hidden" style="aspect-ratio: 16/9;">
                    @if($cover)
                        <img src="{{ $cover }}"
                             alt="{{ $album->title }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-full lmn-bg-navy flex items-center justify-center">
                            <span class="font-display text-white/20 text-4xl uppercase">LMNRY</span>
                        </div>
                    @endif

                    {{-- Hover overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                         style="background: rgba(0,0,0,0.45);">
                        <div class="flex items-center gap-2 px-5 py-2 rounded-full border"
                             style="border-color: rgba(6,182,212,0.6); background: rgba(0,0,0,0.5);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: var(--lmn-cyan);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-white text-xs font-semibold tracking-widest uppercase">Ver álbum</span>
                        </div>
                    </div>

                    {{-- Photo count badge --}}
                    <div class="absolute top-3 right-3 px-2 py-1 rounded text-xs font-semibold"
                         style="background: rgba(0,0,0,0.6); color: rgba(255,255,255,0.7);">
                        {{ $album->gallery_count }} {{ $album->gallery_count === 1 ? 'foto' : 'fotos' }}
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-5">
                    <h2 class="font-display font-black text-white uppercase text-xl leading-tight" style="transition: color .2s;">
                        {{ $album->title }}
                    </h2>
                    @if(!empty($album->description))
                    <p class="text-white/40 text-sm mt-2 leading-relaxed" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $album->description }}
                    </p>
                    @endif
                    @if($album->event)
                    <span class="inline-block mt-3 text-xs tracking-widest uppercase" style="color: var(--lmn-cyan);">
                        {{ $album->event->title }} — {{ $album->event->event_date->format('d M Y') }}
                    </span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </div>
</section>

@endsection
