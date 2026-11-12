<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('trip_date');
            $table->string('from_location');
            $table->string('to_location');
            $table->decimal('kilometers', 7, 1);
            $table->string('vehicle');
            $table->timestamps();

            $table->index(['user_id', 'trip_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
