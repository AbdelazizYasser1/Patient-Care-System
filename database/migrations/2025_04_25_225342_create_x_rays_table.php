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
        Schema::create('x_rays', function (Blueprint $table) {
            $table->id();
            $table->string('Name_of_XRay');
            $table->text('Description_of_XRay');
            $table->string('Result_of_XRay');
            $table->string('type_of_XRay');
            $table->string('image_of_XRay')->index();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('x_rays');
    }
};
