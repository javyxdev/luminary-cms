<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutUs;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutUs::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Nuestra Historia',
                'content' => 'Luminary SV nació con la visión de crear un espacio seguro y vibrante para los amantes de la música electrónica en El Salvador. Desde nuestros inicios, nos hemos enfocado en promover el género Trance y sus derivados, ofreciendo experiencias inmersivas y de alta calidad.',
                'vision' => 'Convertirnos en la productora líder de eventos electrónicos en la región, reconocida por nuestra innovación y pasión.',
                'mission' => 'Proveer eventos de música electrónica excepcionales que conecten a artistas y audiencias en una atmósfera de libertad y respeto.',
                'hero_image_path' => null,
            ]
        );
    }
}
