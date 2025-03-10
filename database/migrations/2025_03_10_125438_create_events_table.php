<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('events', function (Blueprint $table) {
        $table->increments('id');
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description');
        $table->string('location');
        $table->date('date');
        $table->string('category');
        $table->integer('max_participants');
        $table->unsignedInteger('user_id')->nullable(); // Créé par un utilisateur authentifié
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
