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
        Schema::create('pack_calculations', function (Blueprint $table) {
            $table->id();
            $table->text('pack_sizes');
            $table->integer('widget_count')->index();
            $table->text('packs');
            $table->timestamps();

            $table->fullText('pack_sizes')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pack_calculations');
    }
};
