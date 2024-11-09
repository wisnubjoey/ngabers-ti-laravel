<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Hapus kolom image yang lama (jika ada)
            $table->dropColumn('image');
            
            // Tambah kolom baru
            $table->string('media_type')->nullable(); // 'image' atau 'video'
            $table->string('media_path')->nullable(); // path ke file
            $table->integer('likes_count')->default(0); // counter untuk likes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Kembalikan kolom image
            $table->string('image')->nullable();
            
            // Hapus kolom yang baru ditambahkan
            $table->dropColumn(['media_type', 'media_path', 'likes_count']);
        });
    }
};
