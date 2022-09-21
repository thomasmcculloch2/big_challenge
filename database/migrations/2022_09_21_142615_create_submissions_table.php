<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor')->nullable();
            $table->foreign('doctor')->references('id')->on('users')->nullOnDelete();
            $table->foreignId('patient')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('symptoms');
            $table->string('status');
            $table->string('prescription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
};
