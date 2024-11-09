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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();                     // Primary key
        $table->foreignId('user_id')      // Foreign key ke tabel users
              ->constrained()             // Membuat constraint
              ->onDelete('cascade');      // Hapus post jika user dihapus
        $table->string('title');          // Judul post
        $table->text('content');          // Konten post
        $table->string('image')->nullable(); // Foto (opsional)
        $table->timestamps();             // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
