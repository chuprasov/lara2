<?php

use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('user_socials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('social_name');
            $table->string('social_id');

            $table->foreignIdFor(User::class)
            ->constrained()
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('user_socials');
        }
    }
};
