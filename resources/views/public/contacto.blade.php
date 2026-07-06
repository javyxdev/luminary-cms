@extends('layouts.public')

@section('title', 'Contacto — Luminary')
@section('description', 'Ponte en contacto con Luminary para más información sobre nuestros eventos.')

@section('content')

{{-- Page Header --}}
<div class="lmn-bg-navy py-15 text-center">
    <h1 class="font-display font-black uppercase text-white" style="font-size: clamp(3rem, 8vw, 6rem);">
        SOCIAL <span class="lmn-text-cyan">HUB</span>
    </h1>
    <p class="text-white/50 pb-5 text-base">Conéctate con nosotros y únete a la familia LMNRY.</p>
</div>

<div class="h-1 w-full" style="background: linear-gradient(to right, transparent, var(--lmn-cyan), transparent);"></div>

<section class="py-24 lmn-bg-dark">
    <div class="max-w-5xl mx-auto px-5 grid grid-cols-1 md:grid-cols-2 gap-16">

        {{-- Contacto Info --}}
        <div>
            <h2 class="lmn-section-title text-5xl text-white mb-8">PONTE EN<br>CONTACTO</h2>

            @if(!empty($settings['contact_email']))
            <div class="flex items-start gap-4 mb-8">
                <div class="mt-1 p-2 rounded-lg" style="background-color: var(--lmn-navy);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 lmn-text-cyan" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white/30 text-xs uppercase tracking-widest mb-1">Email</p>
                    <a href="mailto:{{ $settings['contact_email'] }}"
                       class="text-white hover:lmn-text-cyan transition-colors">
                        {{ $settings['contact_email'] }}
                    </a>
                </div>
            </div>
            @endif

            {{-- Redes Sociales --}}
            <div>
                <p class="text-white/30 text-xs uppercase tracking-widest mb-4">Síguenos</p>
                <div class="flex gap-4">
                    @if(!empty($settings['footer_instagram']))
                    <a href="{{ $settings['footer_instagram'] }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 lmn-card px-4 py-3 rounded-xl text-white/60 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                        <span class="text-xs uppercase tracking-widest font-semibold">Instagram</span>
                    </a>
                    @endif
                    @if(!empty($settings['footer_facebook']))
                    <a href="{{ $settings['footer_facebook'] }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 lmn-card px-4 py-3 rounded-xl text-white/60 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="text-xs uppercase tracking-widest font-semibold">Facebook</span>
                    </a>
                    @endif
                    @if(!empty($settings['footer_tiktok']))
                    <a href="{{ $settings['footer_tiktok'] }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 lmn-card px-4 py-3 rounded-xl text-white/60 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.74a4.85 4.85 0 01-1.01-.05z"/>
                        </svg>
                        <span class="text-xs uppercase tracking-widest font-semibold">TikTok</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- CTA Eventos --}}
        <div class="lmn-card rounded-xl p-10 flex flex-col justify-between">
            <div>
                <h3 class="font-display font-black text-white text-4xl uppercase mb-4">
                    ¿LISTO PARA<br>LA PRÓXIMA NOCHE?
                </h3>
                <p class="text-white/40 text-sm leading-relaxed mb-8">
                    Descubre nuestros próximos eventos y vive una experiencia de trance y techno que no olvidarás.
                </p>
            </div>
            <div class="space-y-3">
                <a href="{{ route('eventos') }}" class="lmn-btn lmn-btn-cyan block text-center">Ver Eventos</a>
                <a href="{{ route('djs') }}"     class="lmn-btn lmn-btn-outline block text-center text-sm">Conocer los DJs</a>
            </div>
        </div>

    </div>
</section>

@endsection
