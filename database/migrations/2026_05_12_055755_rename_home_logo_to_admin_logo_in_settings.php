<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')
            ->where('key', 'home_logo')
            ->update([
                'key'        => 'admin_logo',
                'label'      => 'Logo del Panel Administrativo',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('settings')
            ->where('key', 'admin_logo')
            ->update([
                'key'        => 'home_logo',
                'label'      => 'Logo del Home / Hero',
                'updated_at' => now(),
            ]);
    }
};
