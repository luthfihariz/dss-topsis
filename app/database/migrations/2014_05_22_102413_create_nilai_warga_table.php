<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNilaiWargaTable extends Migration {

	public function up()
	{
		Schema::create('nilai_warga', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('nilai_id')->unsigned();
			$table->integer('warga_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('nilai_warga');
	}
}