<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero');
            $table->string('date_facture', 50);
            $table->string('departement', 100);
            $table->string('interlocuteur', 100);
            $table->string('mobile', 100);
            $table->string('email', 100);
            $table->string('client', 100);
            $table->string('periodeDebut', 100);
            $table->string('periodeFin', 100);
            $table->string('designation', 200);
            $table->string('destination', 200);
            $table->string('depart', 100);
            $table->integer('quantite');
            $table->integer('jour');
            $table->integer('forfait');
            $table->string('ht', 100);
            $table->string('tva', 100);
            $table->string('ttc', 100);
            $table->string('totalNetLettre', 100);
            $table->integer('nbrePlace');
            $table->string('heureDepart', 10);
            $table->string('heureArrive', 10)->nullable();
            $table->string('climatiseur', 5)->nullable();
            $table->string('dvd', 5)->nullable();
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
        Schema::dropIfExists('locations');
    }
}
