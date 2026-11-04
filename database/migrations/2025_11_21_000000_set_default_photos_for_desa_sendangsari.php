<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Isi logo & foto sampul Desa Sendangsari di database yang sudah ada
     * (misalnya production), hanya jika kolomnya masih kosong.
     */
    public function up(): void
    {
        DB::table('villages')
            ->where('slug', 'desa-sendangsari')
            ->whereNull('cover_photo')
            ->update(['cover_photo' => 'images/villages/cover-desa-sendangsari.jpg']);

        DB::table('villages')
            ->where('slug', 'desa-sendangsari')
            ->where(function ($q) {
                $q->whereNull('logo')->orWhere('logo', '');
            })
            ->update(['logo' => 'images/villages/logo-desa-sendangsari.png']);
    }

    /**
     * Data fix — tidak perlu di-rollback.
     */
    public function down(): void
    {
        //
    }
};
