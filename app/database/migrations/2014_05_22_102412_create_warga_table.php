<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWargaTable extends Migration {

	public function up()
	{
		Schema::create('warga', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('no_ktp', 255)->unique();
			$table->string('nama', 255);
			$table->text('alamat');
		});
	}

	public function down()
	{
		Schema::drop('warga');
	}
}