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
        Schema::create('data', function (Blueprint $table) {
            $table->bigIncrements('geoname_id')->unsigned();
            $table->string('name',200);
            $table->string('asciiname',200);
            $table->string('alternatenames',10000);
            $table->decimal('latitude',10,5);
            $table->decimal('longitude',10,5);
            $table->char('feature_class',1);
            $table->char('feature_code',10);
            $table->char('country_code',2);
            $table->char('cc2',200);
            $table->string('admin1_code',100);
            $table->string('admin2_code',100);
            $table->string('admin3_code',100);
            $table->string('admin4_code',100);
            $table->bigInteger('population');
            $table->string('elevation',200);
            $table->integer('dem');
            $table->string('timezone',40);
            $table->date('modification_date');
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
        Schema::dropIfExists('data');
    }
};
