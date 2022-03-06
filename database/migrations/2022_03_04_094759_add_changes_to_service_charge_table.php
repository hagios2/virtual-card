<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangesToServiceChargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_charges', function (Blueprint $table) {
            $table->dropColumn('private_security_fee');
//            $table->renameColumn('standard_subscription_fee', 'amount');
            $table->string('type');
        });

        \App\Models\ServiceCharge::create([
            'amount' => 500,
            'type' => 'standard'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_charges', function (Blueprint $table) {
            $table->decimal('private_security_fee', 10, 2);
            $table->renameColumn('amount', 'standard_subscription_fee');
            $table->dropColumn('type');
        });
    }
}
