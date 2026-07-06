@extends('layouts.public')

@section('title', 'Nosotros — Luminary')
@section('description', 'Conoce la historia y misión de Luminary, la casa del trance en San Salvador.')

@section('content')

{{-- Page Header (uniforme con resto de páginas) --}}
<div class="lmn-bg-navy py-15 text-center">
    <h1 class="font-display font-black uppercase text-white" style="font-size: clamp(3rem, 8vw, 6rem);">
        SOBRE <span class="lmn-text-cyan">NOSOTROS</span>
    </h1>
    <p class="text-white/50 pb-5 text-base max-w-xl mx-auto px-4">
        Conoce la historia y el espíritu detrás de cada experiencia Luminary.
    </p>
</div>

<div class="h-1 w-full" style="background: linear-gradient(to right, transparent, var(--lmn-cyan), transparent);"></div>

@if($about)
{{-- Contenido Principal: Imagen + Texto --}}
<section class="py-24" style="background-color: #f4f4f6;">
    <div class="max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-1 {{ !empty($about->hero_image_path) ? 'md:grid-cols-2' : '' }} gap-12 md:gap-16 items-center">

            @if(!empty($about->hero_image_path))
            {{-- Imagen --}}
            <div class="relative">
                <img src="{{ asset('storage/' . $about->hero_image_path) }}"
                     alt="{{ $about->title ?? 'Sobre Nosotros' }}"
                     class="w-full h-96 md:h-[500px] object-cover rounded-xl shadow-2xl">
                {{-- Acento decorativo --}}
                <div class="absolute -bottom-4 -left-4 w-24 h-24 rounded-xl -z-10" style="background-color: var(--lmn-cyan); opacity: 0.15;"></div>
                <div class="absolute -top-4 -right-4 w-24 h-24 rounded-xl -z-10" style="background-color: var(--lmn-red); opacity: 0.10;"></div>
            </div>
            @endif

            {{-- Texto --}}
            <div>
                @if(!empty($about->title))
                <h2 class="lmn-section-title text-5xl md:text-6xl mb-6" style="color: var(--lmn-dark);">
                    {{ strtoupper($about->title) }}
                </h2>
                @endif
                @if(!empty($about->content))
                <div class="text-gray-600 leading-relaxed text-base space-y-4">
                    {!! nl2br(e($about->content)) !!}
                </div>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- Visión y Misión --}}
@if(!empty($about->vision) || !empty($about->mission))
<section class="py-24 lmn-bg-dark">
    <div class="max-w-6xl mx-auto px-5 grid grid-cols-1 md:grid-cols-2 gap-12">

        @if(!empty($about->vision))
        <div class="lmn-card rounded-xl p-10">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-1 rounded" style="background-color: var(--lmn-cyan);"></div>
                <h3 class="font-display font-black text-white text-4xl uppercase">VISIÓN</h3>
            </div>
            <p class="text-white/55 leading-relaxed text-sm">{{ $about->vision }}</p>
        </div>
        @endif

        @if(!empty($about->mission))
        <div class="lmn-card rounded-xl p-10">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-1 rounded" style="background-color: var(--lmn-red);"></div>
                <h3 class="font-display font-black text-white text-4xl uppercase">MISIÓN</h3>
            </div>
            <p class="text-white/55 leading-relaxed text-sm">{{ $about->mission }}</p>
        </div>
        @endif
    </div>
</section>
@endif

@else
<section class="py-24 lmn-bg-dark text-center">
    <p class="font-display text-3xl text-white/30 uppercase tracking-widest">Información no disponible</p>
</section>
@endif

{{-- CTA --}}
<section class="py-20 lmn-bg-navy text-center">
    <div class="max-w-2xl mx-auto px-5">
        <h2 class="font-display font-black text-white text-5xl uppercase mb-4">¿LISTO PARA LA PRÓXIMA?</h2>
        <p class="text-white/40 mb-8 text-sm">Únete a la familia Luminary y vive una experiencia que no olvidarás.</p>
        <a href="{{ route('eventos') }}" class="lmn-btn lmn-btn-cyan">Ver Eventos</a>
    </div>
</section>

@endsection
