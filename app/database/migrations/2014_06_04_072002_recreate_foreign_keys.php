<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('nilai', function(Blueprint $table) {
			$table->foreign('kriteria_id')->references('id')->on('kriteria')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('nilai_warga', function(Blueprint $table) {
			$table->foreign('nilai_id')->references('id')->on('nilai')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('nilai_warga', function(Blueprint $table) {
			$table->foreign('warga_id')->references('id')->on('warga')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('nilai', function(Blueprint $table) {
			$table->dropForeign('nilai_kriteria_id_foreign');
		});
		Schema::table('nilai_warga', function(Blueprint $table) {
			$table->dropForeign('nilai_warga_nilai_id_foreign');
		});
		Schema::table('nilai_warga', function(Blueprint $table) {
			$table->dropForeign('nilai_warga_warga_id_foreign');
		});
	}

}
