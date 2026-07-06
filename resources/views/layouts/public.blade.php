<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Luminary — Eventos de Música Electrónica')</title>
    <meta name="description" content="@yield('description', 'Eventos únicos de trance y techno en el corazón de San Salvador.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="lmn-bg-dark text-white antialiased" style="font-family: 'Inter', sans-serif;">

    {{-- ───────────────────────── NAVBAR ───────────────────────────── --}}
    @php
        $logoPath = $settings['site_logo'] ?? '';
        $logoUrl  = $logoPath
            ? (str_contains($logoPath, 'assets/') ? asset($logoPath) : asset('storage/' . $logoPath))
            : '';
    @endphp

    <nav class="fixed top-0 left-0 right-0 z-50 lmn-bg-dark border-b border-white/10" x-data="{ menuOpen: false }">

        {{-- Fila superior: logo siempre centrado; social e hamburger anclados fuera del flujo para que nunca lo desplacen --}}
        <div class="max-w-7xl mx-auto px-5 py-4 md:pt-3 md:pb-0">
            <div class="relative flex items-center justify-center">

                {{-- Social Icons: solo desktop, anclados a la izquierda (fuera del flujo, no afectan el centrado) --}}
                <div class="hidden md:flex items-center gap-4 absolute left-0 top-1/2 -translate-y-1/2">
                    @if(!empty($settings['footer_instagram']))
                    <a href="{{ $settings['footer_instagram'] }}" target="_blank" rel="noopener" title="Instagram"
                       class="text-white/60 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($settings['footer_facebook']))
                    <a href="{{ $settings['footer_facebook'] }}" target="_blank" rel="noopener" title="Facebook"
                       class="text-white/60 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($settings['footer_tiktok']))
                    <a href="{{ $settings['footer_tiktok'] }}" target="_blank" rel="noopener" title="TikTok"
                       class="text-white/60 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.74a4.85 4.85 0 01-1.01-.05z"/>
                        </svg>
                    </a>
                    @endif
                </div>

                {{-- Logo: siempre centrado, solo se limita la altura (nunca se deforma, el ancho es auto) --}}
                <a href="{{ route('home') }}" class="max-w-[62%] sm:max-w-[70%] md:max-w-none">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="Luminary" class="h-10 md:h-[51px] w-auto mx-auto">
                    @else
                        <span class="font-display text-2xl md:text-4xl tracking-[0.2em] md:tracking-[0.3em] text-white font-bold">LUMINARY</span>
                    @endif
                </a>

                {{-- Hamburger: solo móvil, anclado a la derecha (posición fija, nunca colisiona con el logo) --}}
                <button @click="menuOpen = !menuOpen"
                        class="md:hidden absolute right-0 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors" aria-label="Menú">
                    <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="menuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Fila inferior: Nav links (Desktop) --}}
        <div class="hidden md:flex items-center justify-center py-3" style="gap: 2rem;">
            <a href="{{ route('home') }}"      class="nav-link {{ request()->routeIs('home')      ? 'nav-link-active' : '' }}">Home</a>
            <a href="{{ route('eventos') }}"   class="nav-link {{ request()->routeIs('eventos')   ? 'nav-link-active' : '' }}">Eventos</a>
            <a href="{{ route('djs') }}"       class="nav-link {{ request()->routeIs('djs')       ? 'nav-link-active' : '' }}">DJs</a>
            <a href="{{ route('galeria') }}"   class="nav-link {{ request()->routeIs('galeria')   ? 'nav-link-active' : '' }}">Galería</a>
            <a href="{{ route('alianzas') }}"  class="nav-link {{ request()->routeIs('alianzas')  ? 'nav-link-active' : '' }}">Alianzas</a>
            <a href="{{ route('nosotros') }}"  class="nav-link {{ request()->routeIs('nosotros')  ? 'nav-link-active' : '' }}">Nosotros</a>
            <a href="{{ route('contacto') }}"  class="nav-link {{ request()->routeIs('contacto')  ? 'nav-link-active' : '' }}">Contacto</a>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="menuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden lmn-bg-dark border-t border-white/10 px-5 py-4 flex flex-col gap-4">
            <a href="{{ route('home') }}"      class="nav-link text-base {{ request()->routeIs('home')      ? 'nav-link-active' : '' }}">Home</a>
            <a href="{{ route('eventos') }}"   class="nav-link text-base {{ request()->routeIs('eventos')   ? 'nav-link-active' : '' }}">Eventos</a>
            <a href="{{ route('djs') }}"       class="nav-link text-base {{ request()->routeIs('djs')       ? 'nav-link-active' : '' }}">DJs</a>
            <a href="{{ route('galeria') }}"   class="nav-link text-base {{ request()->routeIs('galeria')   ? 'nav-link-active' : '' }}">Galería</a>
            <a href="{{ route('alianzas') }}"  class="nav-link text-base {{ request()->routeIs('alianzas')  ? 'nav-link-active' : '' }}">Alianzas</a>
            <a href="{{ route('nosotros') }}"  class="nav-link text-base {{ request()->routeIs('nosotros')  ? 'nav-link-active' : '' }}">Nosotros</a>
            <a href="{{ route('contacto') }}"  class="nav-link text-base {{ request()->routeIs('contacto')  ? 'nav-link-active' : '' }}">Contacto</a>

            @if(!empty($settings['footer_instagram']) || !empty($settings['footer_facebook']) || !empty($settings['footer_tiktok']))
            <div class="flex items-center gap-5 pt-3 mt-1 border-t border-white/10">
                @if(!empty($settings['footer_instagram']))
                <a href="{{ $settings['footer_instagram'] }}" target="_blank" rel="noopener" title="Instagram"
                   class="text-white/60 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </a>
                @endif
                @if(!empty($settings['footer_facebook']))
                <a href="{{ $settings['footer_facebook'] }}" target="_blank" rel="noopener" title="Facebook"
                   class="text-white/60 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                @endif
                @if(!empty($settings['footer_tiktok']))
                <a href="{{ $settings['footer_tiktok'] }}" target="_blank" rel="noopener" title="TikTok"
                   class="text-white/60 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.74a4.85 4.85 0 01-1.01-.05z"/>
                    </svg>
                </a>
                @endif
            </div>
            @endif
        </div>
    </nav>

    {{-- ───────────────────────── CONTENT ──────────────────────────── --}}
    <main class="pt-20 md:pt-28">
        @yield('content')
    </main>

    {{-- ───────────────────────── FOOTER ───────────────────────────── --}}
    <footer class="lmn-bg-dark border-t border-white/10">
        <div class="max-w-7xl mx-auto px-5 py-16 grid grid-cols-1 md:grid-cols-3 gap-12">

            {{-- Social Hub --}}
            <div>
                <h3 class="lmn-section-title lmn-text-red text-4xl mb-5">SOCIAL HUB</h3>
                <p class="text-white/50 text-sm mb-4">Síguenos en nuestras redes sociales.</p>
                <div class="flex gap-4 mb-6">
                    @if(!empty($settings['footer_instagram']))
                    <a href="{{ $settings['footer_instagram'] }}" target="_blank" rel="noopener"
                       class="text-white/60 hover:lmn-text-cyan hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($settings['footer_facebook']))
                    <a href="{{ $settings['footer_facebook'] }}" target="_blank" rel="noopener"
                       class="text-white/60 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if(!empty($settings['footer_tiktok']))
                    <a href="{{ $settings['footer_tiktok'] }}" target="_blank" rel="noopener"
                       class="text-white/60 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.74a4.85 4.85 0 01-1.01-.05z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                <p class="font-display text-xl tracking-widest text-white mb-1">CONTACTO</p>
                @if(!empty($settings['contact_email']))
                <a href="mailto:{{ $settings['contact_email'] }}"
                   class="text-white/50 hover:text-white text-sm transition-colors">
                    {{ $settings['contact_email'] }}
                </a>
                @endif
            </div>

            {{-- Nav Links --}}
            <div class="flex flex-col gap-3">
                <h3 class="lmn-section-title text-white text-2xl mb-3">NAVEGACIÓN</h3>
                <a href="{{ route('home') }}"      class="nav-link text-sm">Home</a>
                <a href="{{ route('eventos') }}"   class="nav-link text-sm">Eventos</a>
                <a href="{{ route('djs') }}"       class="nav-link text-sm">DJs</a>
                <a href="{{ route('galeria') }}"   class="nav-link text-sm">Galería</a>
                <a href="{{ route('alianzas') }}"  class="nav-link text-sm">Alianzas</a>
                <a href="{{ route('nosotros') }}"  class="nav-link text-sm">Nosotros</a>
                <a href="{{ route('contacto') }}"  class="nav-link text-sm">Contacto</a>
            </div>

            {{-- Logo --}}
            <div class="flex flex-col items-center text-center md:items-start md:text-left justify-start">
                <a href="{{ route('home') }}" class="mb-4">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="Luminary" class="h-12 w-auto opacity-80">
                    @else
                        <span class="font-display text-4xl tracking-[0.3em] text-white/80 font-bold">LUMINARY</span>
                    @endif
                </a>
                <p class="text-white/30 text-xs leading-relaxed">
                    The real haven for trance music.<br>San Salvador, El Salvador.
                </p>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-white/10 py-5 text-center text-white/30 text-xs tracking-widest uppercase">
            {{ $settings['footer_text'] ?? '© ' . date('Y') . ' LMNRY (Luminary) — All rights reserved.' }}
        </div>
    </footer>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
