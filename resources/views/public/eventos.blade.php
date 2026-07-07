@extends('layouts.public')

@section('title', 'Eventos — Luminary')
@section('description', '¡Vive tu próxima gran noche junto a LMNRY! Próximos eventos de música electrónica.')

@section('content')

{{-- Page Header --}}
<div class="lmn-bg-navy py-10 md:py-16 text-center">
    <h1 class="font-display font-black uppercase text-white" style="font-size: clamp(3rem, 8vw, 6rem);">
        EVENTOS <span class="lmn-text-cyan">LMNRY</span>
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
                <div class="flex flex-wrap items-center gap-y-1.5 mb-2">
                    <span class="lmn-text-cyan text-xs sm:text-sm font-semibold tracking-widest uppercase inline-flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                        {{ $event->event_date->format('d F Y') }}
                    </span>
                    <span class="text-white/25 mx-2 text-xs sm:text-sm">|</span>
                    <span class="lmn-text-cyan text-xs sm:text-sm font-semibold tracking-widest uppercase inline-flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        {{ $event->location }}
                    </span>
                    @if($event->event_date->isBefore(today()))
                    <span class="text-white/25 mx-2 text-xs sm:text-sm">|</span>
                    <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wide px-1.5 py-0.5 rounded-full"
                          style="background-color: rgba(229,57,53,0.15); color: var(--lmn-red); border: 1px solid rgba(229,57,53,0.4);">
                        Evento Pasado
                    </span>
                    @endif
                </div>
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
