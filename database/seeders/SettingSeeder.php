<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Identidad Visual
            ['key' => 'site_logo', 'value' => 'assets/img/logo-white.png', 'label' => 'Logo del Menú (PNG/SVG)'],
            
            // Hero del Home (Contenido)
            ['key' => 'hero_title', 'value' => 'THE REAL HAVEN FOR TRANCE MUSIC', 'label' => 'Título Principal del Hero'],
            ['key' => 'hero_subtitle', 'value' => 'Join the evolution of the electronic music scene in SV.', 'label' => 'Subtítulo del Hero'],
            ['key' => 'hero_cta_text', 'value' => 'VER PRÓXIMOS EVENTOS', 'label' => 'Texto del Botón (CTA)'],
            ['key' => 'hero_cta_link', 'value' => '#events', 'label' => 'Enlace del Botón (CTA)'],

            // Hero del Home (Fondo dinámico)
            ['key' => 'hero_bg_type', 'value' => 'image', 'label' => 'Tipo de Fondo (image, video_local, video_youtube)'],
            ['key' => 'hero_bg_path', 'value' => null, 'label' => 'Ruta del Archivo (Imagen/Video)'],
            ['key' => 'hero_youtube_url', 'value' => null, 'label' => 'ID de Video de YouTube (si aplica)'],

            // Contacto y Redes Globales
            ['key' => 'contact_email', 'value' => 'info@luminarysv.com', 'label' => 'Correo de Contacto Oficial'],
            ['key' => 'footer_facebook', 'value' => 'https://facebook.com/luminarysv', 'label' => 'Enlace Facebook'],
            ['key' => 'footer_instagram', 'value' => 'https://instagram.com/luminarysv', 'label' => 'Enlace Instagram'],
            ['key' => 'footer_text', 'value' => 'Luminary SV © 2026. All rights reserved.', 'label' => 'Texto del Footer'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
