<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token', 60)
                ->unique()
                ->nullable();
        });
    }

    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['api_token']);
            });
        }
    }
};
