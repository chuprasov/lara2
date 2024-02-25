<?php

use App\Models\Role;
use Domain\Auth\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Role::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('role_user');
            Schema::dropIfExists('roles');
        }
    }
};
