<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('form_type', 50)->default('booking');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('clinic')->nullable();
            $table->string('reason')->nullable();
            $table->string('body_area')->nullable();
            $table->string('preferred_date')->nullable();
            $table->string('preferred_time')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->string('status', 20)->default('new');
            $table->string('source_page')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
