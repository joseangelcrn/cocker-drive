<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicherosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ficheros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_real');
            $table->string('nombre_hash');
            $table->string('extension');
            $table->float('size');
            $table->float('width')->nullable()->default(null);
            $table->float('height')->nullable()->default(null);
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('ficheros');
    }
}
