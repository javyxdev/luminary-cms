@extends('layouts.public')

@section('title', 'DJs Aliados — Luminary')
@section('description', 'Conoce al selecto equipo de DJs y productores aliados de Luminary.')

@section('content')

{{-- Page Header --}}
<div class="lmn-bg-navy py-10 md:py-16 text-center">
    <h1 class="font-display font-black uppercase text-white" style="font-size: clamp(3rem, 8vw, 6rem);">
        DJS <span class="lmn-text-cyan">ALIADOS</span>
    </h1>
    <p class="text-white/50 pb-5 text-base">Nuestro selecto equipo de DJs y productores.</p>
</div>

<div class="h-1 w-full" style="background: linear-gradient(to right, transparent, var(--lmn-cyan), transparent);"></div>

{{-- DJ Grid --}}
<section class="py-20 lmn-bg-dark">
    <div class="max-w-7xl mx-auto px-5">

        @forelse($djs as $dj)
        <div class="lmn-card rounded-xl overflow-hidden mb-10 flex flex-col md:flex-row">

            {{-- Photo --}}
            <div class="md:w-80 flex-shrink-0">
                @if(!empty($dj->image_path))
                <img src="{{ asset('storage/' . $dj->image_path) }}"
                     alt="{{ $dj->name }}"
                     class="w-full h-72 md:h-full object-cover object-top">
                @else
                <div class="w-full h-72 md:h-full lmn-bg-navy flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white/10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="p-8 flex flex-col justify-between">
                <div>
                    <h2 class="font-display font-black text-white text-5xl uppercase mb-4">{{ $dj->name }}</h2>
                    @if(!empty($dj->biography))
                    <p class="text-white/55 text-sm leading-relaxed mb-6">{{ $dj->biography }}</p>
                    @endif
                </div>

                {{-- Social Links --}}
                <div class="flex flex-wrap gap-3 mt-2">
                    @if(!empty($dj->instagram_url))
                    <a href="{{ $dj->instagram_url }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-white/50 hover:text-white text-xs tracking-widest uppercase transition-colors border border-white/10 hover:border-white/30 px-3 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                        Instagram
                    </a>
                    @endif
                    @if(!empty($dj->soundcloud_url))
                    <a href="{{ $dj->soundcloud_url }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-white/50 hover:text-white text-xs tracking-widest uppercase transition-colors border border-white/10 hover:border-white/30 px-3 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M1.175 12.225c-.131 0-.244.14-.244.312l-.232 2.138.232 2.168c0 .174.113.314.244.314.13 0 .244-.14.244-.314l.254-2.168-.254-2.138c0-.172-.114-.312-.244-.312zm1.48-.899c-.141 0-.272.154-.272.345l-.277 3.036.277 3.016c0 .192.131.347.272.347.142 0 .274-.155.274-.347l.312-3.016-.312-3.036c0-.191-.132-.345-.274-.345zm1.5-.253c-.155 0-.3.17-.3.378l-.276 3.289.276 3.215c0 .208.145.378.3.378.156 0 .3-.17.3-.378l.312-3.215-.312-3.289c0-.208-.144-.378-.3-.378zm1.51-.13c-.168 0-.325.183-.325.41l-.275 3.419.275 3.3c0 .228.157.411.325.411.17 0 .326-.183.326-.411l.31-3.3-.31-3.419c0-.227-.156-.41-.326-.41zm1.51.029c-.182 0-.35.197-.35.443l-.274 3.39.274 3.28c0 .246.168.443.35.443.183 0 .352-.197.352-.443l.308-3.28-.308-3.39c0-.246-.169-.443-.352-.443zm1.51.228c-.195 0-.375.21-.375.476l-.273 3.162.273 3.08c0 .265.18.476.375.476.196 0 .377-.211.377-.476l.306-3.08-.306-3.162c0-.266-.181-.476-.377-.476zm1.514-.105c-.208 0-.4.224-.4.508l-.27 3.267.27 3.154c0 .284.192.508.4.508.21 0 .402-.224.402-.508l.304-3.154-.304-3.267c0-.284-.192-.508-.402-.508zm1.514-.31c-.222 0-.426.237-.426.54l-.268 3.577.268 3.416c0 .304.204.54.426.54.223 0 .427-.236.427-.54l.302-3.416-.302-3.577c0-.303-.204-.54-.427-.54zm1.518.16c-.236 0-.452.25-.452.572l-.267 3.417.267 3.261c0 .323.216.573.452.573.236 0 .452-.25.452-.573l.3-3.261-.3-3.417c0-.322-.216-.572-.452-.572zm1.517-.35c-.249 0-.478.264-.478.604l-.265 3.767.265 3.543c0 .34.229.605.478.605.249 0 .478-.265.478-.605l.297-3.543-.297-3.767c0-.34-.229-.604-.478-.604zm1.52.015c-.262 0-.504.277-.504.636l-.264 3.752.264 3.532c0 .36.242.637.504.637.263 0 .506-.277.506-.637l.295-3.532-.295-3.752c0-.359-.243-.636-.506-.636zm1.52-.297c-.277 0-.531.29-.531.668l-.263 4.049.263 3.79c0 .377.254.668.531.668.278 0 .532-.291.532-.668l.292-3.79-.292-4.049c0-.378-.254-.668-.532-.668zm4.08.62c-.26 0-.51.044-.742.12C20.12 9.1 18.954 7.5 17.07 7.5c-.453 0-.887.108-1.274.3v8.29c0 .434.358.787.798.787h7.157c.44 0 .797-.353.797-.787 0-.434-.357-.787-.797-.787h-.03l.003-.003z"/>
                        </svg>
                        SoundCloud
                    </a>
                    @endif
                    @if(!empty($dj->beatport_url))
                    <a href="{{ $dj->beatport_url }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-white/50 hover:text-white text-xs tracking-widest uppercase transition-colors border border-white/10 hover:border-white/30 px-3 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9.5 3A6.5 6.5 0 0116 9.5c0 1.61-.59 3.09-1.56 4.23l.27.27h.79l5 5-1.5 1.5-5-5v-.79l-.27-.27A6.516 6.516 0 019.5 16 6.5 6.5 0 013 9.5 6.5 6.5 0 019.5 3m0 2C7 5 5 7 5 9.5S7 14 9.5 14 14 12 14 9.5 12 5 9.5 5z"/>
                        </svg>
                        Beatport
                    </a>
                    @endif
                    @if(!empty($dj->tiktok_url))
                    <a href="{{ $dj->tiktok_url }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-white/50 hover:text-white text-xs tracking-widest uppercase transition-colors border border-white/10 hover:border-white/30 px-3 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V9.17a8.2 8.2 0 004.79 1.52V7.24a4.85 4.85 0 01-1.02-.55z"/>
                        </svg>
                        TikTok
                    </a>
                    @endif
                    @if(!empty($dj->facebook_url))
                    <a href="{{ $dj->facebook_url }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-white/50 hover:text-white text-xs tracking-widest uppercase transition-colors border border-white/10 hover:border-white/30 px-3 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-24">
            <p class="font-display text-3xl text-white/30 uppercase tracking-widest">Sin DJs registrados</p>
        </div>
        @endforelse
    </div>
</section>

@endsection
