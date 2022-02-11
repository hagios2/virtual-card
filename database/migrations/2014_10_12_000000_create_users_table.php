<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number');
            $table->string('postal_address');
            $table->string('physical_address');
            $table->string('property_color');
            $table->string('closest_landmark');
            $table->text('property_description');
            $table->text('special_note')->nullable();
            $table->string('emergency_contact1_name');
            $table->string('emergency_contact1_phone_number');
            $table->string('emergency_contact2_name')->nullable();
            $table->string('emergency_contact2_phone_number')->nullable();
            $table->string('emergency_contact3_name')->nullable();
            $table->string('emergency_contact3_phone_number')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
