<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMomoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('momo', function (Blueprint $table) {
            $table->id();
            $table->enum('product', ['collection', 'disbursement', 'remittance']);
            $table->enum('environment', ['sandbox', 'production']);
            $table->string('primary_key')->unique();
            $table->string('secondary_key')->unique();
            $table->timestamps();
        });

        Schema::create('momo_options', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value');
            $table->unsignedBigInteger('momo_id');
            $table->timestamps();
            $table->foreign('momo_id')->references('id')->on('momo')->onDelete('cascade');
            $table->unique('key', 'momo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('momo');
    }
}
