<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
            ['key' => 'hero_slide_1', 'value' => '', 'label' => 'Hero Slide 1'],
            ['key' => 'hero_slide_2', 'value' => '', 'label' => 'Hero Slide 2'],
            ['key' => 'hero_slide_3', 'value' => '', 'label' => 'Hero Slide 3'],
            ['key' => 'hero_slide_4', 'value' => '', 'label' => 'Hero Slide 4'],
        ];

        foreach ($rows as $row) {
            DB::table('settings')->insertOrIgnore(array_merge($row, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'hero_slide_1', 'hero_slide_2', 'hero_slide_3', 'hero_slide_4',
        ])->delete();
    }
};
