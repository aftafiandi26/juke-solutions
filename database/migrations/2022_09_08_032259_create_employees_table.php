<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('users_id')->constrained('users')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('position');
            $table->date('bod');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('province');
            $table->string('city');
            $table->string('address');
            $table->string('code_pos');
            $table->integer('ktp')->unique();
            $table->string('rek_bank_position');
            $table->string('rek_bank');
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
        Schema::dropIfExists('employees');
    }
};
