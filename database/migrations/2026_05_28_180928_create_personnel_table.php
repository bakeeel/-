<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('military_id')->unique()->index();
            $table->string('rank');
            $table->string('primary_specialty');
            $table->string('sub_specialty')->nullable();
            $table->date('appointment_date');
            $table->date('confirmation_date')->nullable();
            $table->date('current_promotion_date');
            $table->string('avatar')->nullable();
            $table->enum('status', ['active', 'retired', 'suspended', 'on_leave'])->default('active');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnel');
    }
};