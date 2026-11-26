<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_counters', function (Blueprint $table) {
            $table->char('year_month', 4)->primary();
            $table->unsignedInteger('last_sequence')->default(0);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 20)->unique();
            $table->char('tracking_token', 32)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('courier_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('promo_code_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('delivery_zone_id')->nullable()->constrained()->nullOnDelete();

            // Coordonnées
            $table->string('civility', 10)->nullable();
            $table->string('customer_name');
            $table->string('customer_phone', 30)->index();
            $table->string('customer_email')->nullable();

            // Livraison
            $table->enum('delivery_mode', ['domicile', 'retrait', 'international'])->default('domicile');
            $table->string('delivery_country', 100)->default('Sénégal');
            $table->string('delivery_city', 100)->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('postal_code', 30)->nullable();
            $table->string('gps_landmark')->nullable();
            $table->string('delivery_slot', 60)->nullable();
            $table->string('carrier_tracking_number', 80)->nullable();

            // Montants FCFA
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('discount_amount')->default(0);
            $table->unsignedInteger('shipping_amount')->default(0);
            $table->unsignedInteger('total_amount');

            // Paiement simulé
            $table->enum('payment_method', ['carte_simulee', 'wave_simule', 'orange_money_simule', 'especes'])->default('especes');
            $table->enum('payment_status', ['en_attente', 'paye', 'echoue'])->default('en_attente')->index();
            $table->boolean('is_simulated_payment')->default(true);

            // Statut commande
            $table->enum('status', [
                'nouvelle',
                'confirmee',
                'en_preparation',
                'livraison_programmee',
                'prete_au_retrait',
                'expediee',
                'en_cours_de_livraison',
                'livree',
                'annulee',
            ])->default('nouvelle')->index();

            $table->timestamps();
            $table->index('created_at');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_title');
            $table->string('variant_label')->nullable();
            $table->string('sku', 60)->nullable();
            $table->unsignedInteger('unit_price');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('line_total');
            $table->timestamps();
        });

        Schema::create('order_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event_type', 60);
            $table->string('status_from', 40)->nullable();
            $table->string('status_to', 40)->nullable();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_events');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_counters');
    }
};
