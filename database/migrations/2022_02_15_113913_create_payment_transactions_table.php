<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('currency')->default('GHS');
            $table->decimal('amount', 10, 2);
            $table->foreignId('user_id')->constrained('users');
            $table->string('reference')->unique();
            $table->string('callback_url')->unique();
            $table->string('email');
            $table->string('channel')->nullable(); //momo or card
            $table->string('ip_address')->nullable();
            $table->text('metadata')->nullable();
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
        Schema::dropIfExists('payment_transactions');
    }
}
