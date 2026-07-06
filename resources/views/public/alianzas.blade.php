@extends('layouts.public')

@section('title', 'Alianzas — Luminary')
@section('description', 'Conoce las alianzas y socios estratégicos que hacen posible cada experiencia Luminary.')

@section('content')

{{-- ── Page Header ──────────────────────────────────────────────── --}}
<div class="lmn-bg-navy py-10 md:py-16 text-center">
    <h1 class="font-display font-black uppercase text-white" style="font-size: clamp(3rem, 8vw, 6rem);">
        NUESTRAS <span class="lmn-text-cyan">ALIANZAS</span>
    </h1>
    <p class="text-white/50 pb-5 text-base max-w-xl mx-auto px-4">
        Las alianzas que hacen posible cada experiencia única de Luminary.
    </p>
</div>

<div class="h-1 w-full" style="background: linear-gradient(to right, transparent, var(--lmn-cyan), transparent);"></div>

{{-- ── Partners Grid ────────────────────────────────────────────── --}}
<section class="py-20 lmn-bg-dark">
    <div class="max-w-7xl mx-auto px-5">

        @forelse($partners as $partner)

        {{-- Card horizontal alternada --}}
        <div class="lmn-card rounded-2xl overflow-hidden mb-10 flex flex-col {{ $loop->even ? 'md:flex-row-reverse' : 'md:flex-row' }}">

            {{-- Imagen --}}
            <div class="md:w-1/2 flex-shrink-0 relative group overflow-hidden" style="min-height: 360px;">
                @if(!empty($partner->logo_path))
                    <img src="{{ asset('storage/' . $partner->logo_path) }}"
                         alt="{{ $partner->name }}"
                         class="w-full h-full object-cover absolute inset-0 transition-transform duration-500 group-hover:scale-105"
                         style="min-height: 360px;">
                @else
                    <div class="absolute inset-0 lmn-bg-navy flex items-center justify-center">
                        <span class="font-display text-white/10 text-7xl uppercase">{{ strtoupper(substr($partner->name, 0, 2)) }}</span>
                    </div>
                @endif

                {{-- Overlay hover con botón --}}
                @if(!empty($partner->website_url))
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/55 transition-all duration-300 flex items-center justify-center">
                    <a href="{{ $partner->website_url }}" target="_blank" rel="noopener"
                       class="lmn-btn lmn-btn-cyan opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-3 group-hover:translate-y-0">
                        Visitar Sitio
                    </a>
                </div>
                @endif
            </div>

            {{-- Contenido --}}
            <div class="md:w-1/2 p-10 md:p-14 flex flex-col justify-center">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-1 rounded" style="background-color: var(--lmn-cyan);"></div>
                    <span class="text-white/30 text-xs tracking-[0.2em] uppercase">Alianza Estratégica</span>
                </div>

                <h2 class="font-display font-black text-white uppercase mb-5 leading-none"
                    style="font-size: clamp(2.5rem, 4vw, 4rem);">
                    {{ strtoupper($partner->name) }}
                </h2>

                @if(!empty($partner->description))
                <p class="text-white/55 leading-relaxed text-base mb-8">
                    {{ $partner->description }}
                </p>
                @endif

                @if(!empty($partner->website_url))
                <div>
                    <a href="{{ $partner->website_url }}" target="_blank" rel="noopener"
                       class="lmn-btn lmn-btn-outline inline-block text-sm">
                        Visitar Sitio →
                    </a>
                </div>
                @endif
            </div>
        </div>

        @empty
        <div class="text-center py-24">
            <p class="font-display text-3xl text-white/30 uppercase tracking-widest">Sin alianzas registradas</p>
            <p class="text-white/20 mt-3 text-sm">Pronto anunciaremos nuevas alianzas.</p>
        </div>
        @endforelse

    </div>
</section>

{{-- ── CTA ──────────────────────────────────────────────────────── --}}
<section class="py-20 lmn-bg-navy border-t border-white/10">
    <div class="max-w-3xl mx-auto px-5 text-center">
        <p class="text-white/30 text-xs tracking-[0.2em] uppercase mb-4">¿Quieres formar parte?</p>
        <h2 class="font-display font-black text-white uppercase mb-5"
            style="font-size: clamp(2rem, 5vw, 3.5rem);">
            SÉ PARTE DE<br><span class="lmn-text-cyan">LA FAMILIA LMNRY</span>
        </h2>
        <p class="text-white/40 text-sm leading-relaxed mb-8 max-w-md mx-auto">
            Si tu marca comparte nuestra pasión por la música electrónica y quieres ser parte de algo único, contáctanos.
        </p>
        <a href="{{ route('contacto') }}" class="lmn-btn lmn-btn-cyan">
            Contáctanos
        </a>
    </div>
</section>

@endsection
