<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UseRealFieldOfWarga extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('warga', function($table){
			$table->dropColumn('no_ktp');
			$table->dropColumn('nama');
			$table->string('no_kk',50)->unique();
			$table->string('no_kps',50);
			$table->string('nama_krt',50);
			$table->string('nama_pasangan_krt',50);
			$table->integer('jml_anggota_keluarga');
			$table->string('propinsi',100);
			$table->string('kabupaten_kota',100);
			$table->string('kelurahan_desa',100);
			$table->string('rt',10);
			$table->string('rw',10);
			$table->string('kode_pos',20);			
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('warga');
	}

}
