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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
        $table->string('bio')->nullable();
            $table->string('motor_merk')->nullable();
            $table->string('motor_type')->nullable();
            $table->string('motor_year')->nullable();
            $table->string('motor_odo')->nullable();
            $table->string('instagram')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('bio');
            $table->dropColumn('motor_merk');
            $table->dropColumn('motor_type');
            $table->dropColumn('motor_year');
            $table->dropColumn('motor_odo');
            $table->dropColumn('instagram');
        });
    }
};
