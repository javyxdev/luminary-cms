@extends('layouts.public')

@section('title', 'Eventos — Luminary')
@section('description', '¡Vive tu próxima gran noche junto a LMNRY! Próximos eventos de música electrónica.')

@section('content')

{{-- Page Header --}}
<div class="lmn-bg-navy py-10 md:py-16 text-center">
    <h1 class="font-display font-black uppercase text-white" style="font-size: clamp(3rem, 8vw, 6rem);">
        PRÓXIMOS <span class="lmn-text-cyan">EVENTOS</span>
    </h1>
    <p class="text-white/50 pb-5 text-base">¡Vive tu próxima gran noche junto a LMNRY!</p>
</div>

{{-- Divider --}}
<div class="h-1 w-full" style="background: linear-gradient(to right, transparent, var(--lmn-cyan), transparent);"></div>

{{-- Events List --}}
<section class="py-16 lmn-bg-dark">
    <div class="max-w-5xl mx-auto px-5">

        @forelse($events as $event)
        <div class="lmn-card rounded-xl overflow-hidden mb-8 flex flex-col md:flex-row">

            {{-- Poster --}}
            <div class="md:w-72 flex-shrink-0">
                @if(!empty($event->image_path))
                <img src="{{ asset('storage/' . $event->image_path) }}"
                     alt="{{ $event->title }}"
                     class="w-full h-64 md:h-full object-cover">
                @else
                <div class="w-full h-64 md:h-full flex items-center justify-center lmn-bg-navy">
                    <span class="font-display text-white/20 text-4xl">LMNRY</span>
                </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="p-8 flex flex-col justify-center">
                <p class="lmn-text-cyan text-sm font-semibold tracking-widest uppercase mb-2">
                    {{ $event->event_date->format('d F Y') }} / {{ $event->location }}
                </p>
                <h2 class="font-display font-black text-white text-4xl md:text-5xl uppercase mb-4">
                    {{ $event->title }}
                </h2>
                @if(!empty($event->description))
                <p class="text-white/50 text-sm leading-relaxed mb-6 line-clamp-3">
                    {{ $event->description }}
                </p>
                @endif
                @if(!empty($event->external_link))
                <div>
                    <a href="{{ $event->external_link }}" target="_blank" rel="noopener"
                       class="lmn-btn lmn-btn-cyan inline-block">
                        Comprar Entradas
                    </a>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-24">
            <p class="font-display text-3xl text-white/30 uppercase tracking-widest">No hay eventos próximos</p>
            <p class="text-white/20 mt-3 text-sm">Vuelve pronto para más noticias.</p>
        </div>
        @endforelse

    </div>
</section>

@endsection
