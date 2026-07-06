@extends('layouts.public')

@section('title', 'Luminary — The Real Haven for Trance Music')

@section('content')

{{-- ───────────────────────── HERO ─────────────────────────────── --}}
@php
    $heroBgType = $settings['hero_bg_type'] ?? 'image';

    // Preparar slides si aplica
    $heroSlides = [];
    if ($heroBgType === 'slider') {
        foreach (['hero_slide_1','hero_slide_2','hero_slide_3','hero_slide_4'] as $k) {
            if (!empty($settings[$k])) $heroSlides[] = asset('storage/' . $settings[$k]);
        }
        if (count($heroSlides) < 1) $heroBgType = 'image'; // fallback si no hay slides
    }

    // Bicolor title
    $heroRaw   = $settings['hero_title'] ?? "THE REAL HAVEN\nFOR TRANCE MUSIC";
    $heroLines = explode("\n", $heroRaw);
    if (count($heroLines) === 1) {
        $words  = explode(' ', trim($heroRaw));
        $mid    = (int) ceil(count($words) / 2);
        $heroLines = [
            implode(' ', array_slice($words, 0, $mid)),
            implode(' ', array_slice($words, $mid)),
        ];
    }
@endphp

<section class="relative flex items-center justify-center overflow-hidden -mt-20 md:-mt-28"
         style="height: 100vh;"
         @if($heroBgType === 'slider' && count($heroSlides) > 1) x-data="heroSlider({{ json_encode($heroSlides) }})" x-init="init()" @endif>

    {{-- ── Background ── --}}
    @if($heroBgType === 'slider')
        @foreach($heroSlides as $i => $slideUrl)
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             @if(count($heroSlides) > 1) :style="{ opacity: current === {{ $i }} ? 1 : 0 }" @endif
             style="background-image: url('{{ $slideUrl }}'); transition: opacity 1s ease-in-out; opacity: {{ $i === 0 ? '1' : '0' }};"></div>
        @endforeach

    @elseif($heroBgType === 'video_local' && !empty($settings['hero_bg_path']))
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
            <source src="{{ asset('storage/' . $settings['hero_bg_path']) }}">
        </video>

    @elseif($heroBgType === 'video_youtube' && !empty($settings['hero_youtube_url']))
        <div class="absolute inset-0 overflow-hidden">
            <iframe class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[177.78vh] min-w-full h-[56.25vw] min-h-full pointer-events-none"
                src="https://www.youtube.com/embed/{{ $settings['hero_youtube_url'] }}?autoplay=1&mute=1&loop=1&playlist={{ $settings['hero_youtube_url'] }}&controls=0&showinfo=0&rel=0&iv_load_policy=3"
                frameborder="0" allow="autoplay; encrypted-media"></iframe>
        </div>

    @elseif(!empty($settings['hero_bg_path']))
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('{{ asset('storage/' . $settings['hero_bg_path']) }}')"></div>

    @else
        <div class="absolute inset-0 lmn-bg-navy"></div>
    @endif

    {{-- ── Overlay ── --}}
    <div class="absolute inset-0 hero-overlay"></div>

    {{-- ── Cyber FX ── --}}
    <canvas id="hero-matrix" class="absolute inset-0 w-full h-full" style="z-index: 2; opacity: 0.55;"></canvas>
    <div class="absolute inset-0 hero-scanlines"></div>
    <div class="absolute inset-0 hero-grid"></div>
    <div class="absolute inset-0 hero-sweep"></div>
    <div class="absolute inset-0 hero-vignette"></div>
    <div class="hero-corner hero-corner-tl"></div>
    <div class="hero-corner hero-corner-tr"></div>
    <div class="hero-corner hero-corner-bl"></div>
    <div class="hero-corner hero-corner-br"></div>

    {{-- ── Content ── --}}
    <div class="relative text-center px-4 max-w-5xl mx-auto" style="z-index: 10;">
        <h1 class="font-display font-black text-white uppercase leading-none" style="font-size: clamp(3.5rem, 10vw, 8rem); text-shadow: 0 2px 24px rgba(0,0,0,0.7), 0 1px 6px rgba(0,0,0,0.5);">
            {{ $heroLines[0] }}<br>
            <span style="color: var(--lmn-cyan);">{{ $heroLines[1] ?? '' }}</span>
        </h1>
        @if(!empty($settings['hero_subtitle']))
        <p class="mt-5 text-white/75 text-lg max-w-xl mx-auto leading-relaxed">
            {{ $settings['hero_subtitle'] }}
        </p>
        @endif
        <a href="{{ $settings['hero_cta_link'] ?? route('eventos') }}" class="lmn-btn lmn-btn-dark mt-10">
            {{ $settings['hero_cta_text'] ?? 'IR A EVENTOS' }}
        </a>
    </div>

    {{-- ── Slider Controls (solo en modo slider con 2+ imágenes) ── --}}
    @if($heroBgType === 'slider' && count($heroSlides) > 1)

    {{-- Flechas --}}
    <button @click="prev()" aria-label="Anterior"
            class="absolute left-5 top-1/2 -translate-y-1/2 flex items-center justify-center rounded-full transition-all"
            style="z-index: 20; width: 44px; height: 44px; background: rgba(0,0,0,0.35); border: 1px solid rgba(6,182,212,0.4); color: rgba(255,255,255,0.8);"
            onmouseover="this.style.background='rgba(6,182,212,0.25)'" onmouseout="this.style.background='rgba(0,0,0,0.35)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <button @click="next()" aria-label="Siguiente"
            class="absolute right-5 top-1/2 -translate-y-1/2 flex items-center justify-center rounded-full transition-all"
            style="z-index: 20; width: 44px; height: 44px; background: rgba(0,0,0,0.35); border: 1px solid rgba(6,182,212,0.4); color: rgba(255,255,255,0.8);"
            onmouseover="this.style.background='rgba(6,182,212,0.25)'" onmouseout="this.style.background='rgba(0,0,0,0.35)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Dots --}}
    <div class="absolute flex gap-2" style="z-index: 20; bottom: 5rem; left: 50%; transform: translateX(-50%);">
        @foreach($heroSlides as $i => $slideUrl)
        <button @click="goTo({{ $i }})" aria-label="Slide {{ $i + 1 }}"
                :style="{{ $i }} === current
                    ? 'width:28px; background: rgba(6,182,212,0.9);'
                    : 'width:10px; background: rgba(255,255,255,0.35);'"
                style="height:10px; border-radius:5px; border:none; padding:0; transition: all 0.3s ease; cursor:pointer;"></button>
        @endforeach
    </div>

    @endif

    {{-- ── Scroll indicator ── --}}
    <div class="absolute left-1/2 -translate-x-1/2 animate-bounce opacity-40" style="z-index: 10; bottom: 2rem;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- ───────────────────────── EXPERIENCIA ──────────────────────── --}}
@if($about)
<section class="py-12 md:py-24" style="background-color: #f4f4f6;">
    <div class="max-w-7xl mx-auto px-5 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">

        {{-- Texto --}}
        <div class="text-center md:text-left">
            <h2 class="lmn-section-title text-5xl md:text-6xl mb-6" style="color: var(--lmn-dark);">
                {{ $about->title ?? 'EXPERIENCIA ÍNTIMA' }}
            </h2>
            <p class="text-gray-600 leading-relaxed mb-8 text-base">
                {{ $about->content }}
            </p>
            <a href="{{ route('nosotros') }}" class="lmn-btn lmn-btn-outline" style="color: var(--lmn-dark); border-color: var(--lmn-dark);">
                Conoce más
            </a>
        </div>

        {{-- Imagen + Stats --}}
        <div class="relative">
            @if(!empty($settings['home_about_image']))
            <img src="{{ asset('storage/' . $settings['home_about_image']) }}"
                 alt="Luminary Experience"
                 class="w-full h-96 object-cover rounded-xl shadow-2xl">
            @else
            <div class="w-full h-96 rounded-xl lmn-bg-navy flex items-center justify-center">
                <span class="font-display text-white/20 text-6xl">LMNRY</span>
            </div>
            @endif

            {{-- Stats overlay --}}
            <div class="absolute bottom-4 left-4 right-4 md:right-auto md:-bottom-6 md:-left-6 lmn-bg-navy rounded-xl p-4 md:p-6 shadow-2xl border border-white/10">
                <div class="flex gap-4 md:gap-8">
                    <div>
                        <p class="font-display text-5xl text-white font-black">+{{ $djsCount }}</p>
                        <p class="text-white/50 text-xs mt-1 max-w-[120px] leading-snug">DJs y productores aliados</p>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div>
                        <p class="font-display text-5xl text-white font-black">+{{ $eventsCount }}</p>
                        <p class="text-white/50 text-xs mt-1">Eventos realizados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ───────────────────────── ALIANZAS ─────────────────────────── --}}
@if($partners->count() > 0)
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-5">
        <div class="text-center mb-14">
            <h2 class="lmn-section-title text-6xl md:text-7xl mb-4" style="color: var(--lmn-dark);">ALIANZAS</h2>
            <p class="text-gray-500 text-base max-w-xl mx-auto">
                Creamos experiencias inolvidables en música trance, techno y melodic techno para todos los amantes del género.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($partners as $partner)
            <div class="group">
                @if(!empty($partner->logo_path))
                <div class="overflow-hidden rounded-xl mb-4 aspect-video bg-gray-100">
                    <img src="{{ asset('storage/' . $partner->logo_path) }}"
                         alt="{{ $partner->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                @endif
                <h3 class="lmn-section-title text-2xl mb-2" style="color: var(--lmn-dark);">{{ strtoupper($partner->name) }}</h3>
                @if(!empty($partner->description))
                <p class="text-gray-500 text-sm leading-relaxed">{{ $partner->description }}</p>
                @endif
                @if(!empty($partner->website_url))
                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener"
                   class="inline-block mt-3 text-xs font-semibold tracking-widest uppercase lmn-text-cyan hover:underline">
                    Ver más →
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ───────────────────────── CTA EVENTOS ─────────────────────── --}}
<section class="py-24 lmn-bg-navy text-center">
    <div class="max-w-3xl mx-auto px-5">
        <h2 class="font-display font-black text-white text-6xl md:text-7xl uppercase mb-4">
            PRÓXIMOS<br><span class="lmn-text-cyan">EVENTOS</span>
        </h2>
        <p class="text-white/50 mb-10">¡Vive tu próxima gran noche junto a LMNRY!</p>
        <a href="{{ route('eventos') }}" class="lmn-btn lmn-btn-cyan">Ver todos los eventos</a>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── Hero Slider (Alpine.js) ────────────────────────────────────────────
function heroSlider(slides) {
    return {
        slides: slides,
        current: 0,
        timer: null,
        init() {
            if (this.slides.length > 1) {
                this.timer = setInterval(() => this.next(), 5000);
            }
        },
        next() {
            this.current = (this.current + 1) % this.slides.length;
            this.resetTimer();
        },
        prev() {
            this.current = (this.current - 1 + this.slides.length) % this.slides.length;
            this.resetTimer();
        },
        goTo(index) {
            this.current = index;
            this.resetTimer();
        },
        resetTimer() {
            clearInterval(this.timer);
            this.timer = setInterval(() => this.next(), 5000);
        },
    };
}

// ── Matrix Rain ───────────────────────────────────────────────────────
(function () {
    const canvas = document.getElementById('hero-matrix');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    const FONT_SIZE  = 13;
    const SPACING    = FONT_SIZE * 2.2; // columnas dispersas
    const CHARS      = '01アイウエカキクサシスタチツ░▒▓><[]{}◆○◉#$%';
    const HEAD_ALPHA = 0.55;
    const TRAIL_LEN  = 10;

    let cols, drops;

    function resize() {
        canvas.width  = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    }

    function init() {
        resize();
        cols  = Math.floor(canvas.width / SPACING);
        drops = Array.from({ length: cols }, () => Math.random() * -(canvas.height / FONT_SIZE));
    }

    function rndChar() {
        return CHARS[Math.floor(Math.random() * CHARS.length)];
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.font = FONT_SIZE + 'px monospace';

        for (let i = 0; i < cols; i++) {
            const headY = drops[i] * FONT_SIZE;

            // cola (caracteres previos, cada vez más tenues)
            for (let t = TRAIL_LEN; t >= 1; t--) {
                const y = headY - t * FONT_SIZE;
                if (y < 0) continue;
                const alpha = (HEAD_ALPHA / TRAIL_LEN) * (TRAIL_LEN - t + 1) * 0.5;
                ctx.fillStyle = `rgba(6,182,212,${alpha.toFixed(3)})`;
                ctx.fillText(rndChar(), i * SPACING, y);
            }

            // cabeza (caracter más brillante)
            if (headY >= 0 && headY <= canvas.height) {
                ctx.fillStyle = `rgba(6,182,212,${HEAD_ALPHA})`;
                ctx.fillText(rndChar(), i * SPACING, headY);
            }

            drops[i]++;

            // reset aleatorio cuando sale por abajo
            if (headY > canvas.height && Math.random() > 0.975) {
                drops[i] = Math.random() * -(canvas.height / FONT_SIZE * 0.5);
            }
        }
    }

    init();
    window.addEventListener('resize', init);
    setInterval(draw, 55);
})();
</script>
@endpush
