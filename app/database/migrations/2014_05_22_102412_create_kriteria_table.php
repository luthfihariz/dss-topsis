<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKriteriaTable extends Migration {

	public function up()
	{
		Schema::create('kriteria', function(Blueprint $table) {
			$table->increments('id');
			$table->string('nama', 255);
			$table->integer('bobot');
		});
	}

	public function down()
	{
		Schema::drop('kriteria');
	}
}