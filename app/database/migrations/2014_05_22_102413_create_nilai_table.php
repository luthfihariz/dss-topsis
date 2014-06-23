<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNilaiTable extends Migration {

	public function up()
	{
		Schema::create('nilai', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('kriteria_id')->unsigned();
			$table->string('nama');
			$table->integer('nilai');
		});
	}

	public function down()
	{
		Schema::drop('nilai');
	}
}