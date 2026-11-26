<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pro_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('company_name');
            $table->string('ninea', 60)->nullable();
            $table->string('trade_register', 60)->nullable();
            $table->enum('activity_type', ['boutique', 'hotel', 'decorateur', 'exportateur'])->default('boutique');
            $table->string('contact_name');
            $table->string('whatsapp', 30);
            $table->text('address');
            $table->string('estimated_monthly_volume')->nullable();
            $table->unsignedTinyInteger('discount_rate')->default(25);
            $table->enum('status', ['en_attente', 'valide', 'refuse'])->default('en_attente')->index();
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label', 60)->default('Domicile');
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('country', 100)->default('Sénégal');
            $table->string('city', 100)->default('Dakar');
            $table->string('district', 120)->nullable();
            $table->text('address_line');
            $table->string('gps_hint')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('pro_profiles');
    }
};
