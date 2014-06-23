<?php 

class RaskinTableSeeder extends Seeder{

	public function run(){

		//clear database
		DB::table('warga')->delete();
		DB::table('kriteria')->delete();
		DB::table('nilai')->delete();
		DB::table('nilai_warga')->delete();

		//seed warga
		$wargaUjang = Warga::create(array(
				'nama' => 'Ujang',
				'no_ktp' => '1236712367123123',
				'alamat' => 'Jl. Raya Pajajaran Komplek BPT'
			));

		$wargaUdin = Warga::create(array(
				'nama' => 'Udin',
				'no_ktp' => '767162371111111',
				'alamat' => 'Jl. Raya Pajajaran Komplek BPT'
			));		

		$this->command->info('Warga masuk');


		//seed dinding

		$kriteriaAtap = Kriteria::create(array(
				'nama' => 'Atap Rumah',
				'bobot' => 6,
			));

		$kriteriaDinding = Kriteria::create(array(
				'nama' => 'Dinding',
				'bobot' => 4,
			));

		$this->command->info("kriteria masuk!");

		//seed nilai

		$nilaiAtapDaun = Nilai::create(array(
				'kriteria_id' => $kriteriaAtap->id,
				'nama' => 'Daun',
				'nilai' => '2'
			));

		$nilaiAtapGenteng = Nilai::create(array(
				'kriteria_id' => $kriteriaAtap->id,
				'nama' => 'Genteng',
				'nilai' => '1'
			));

		$nilaiDindingTriplek = Nilai::create(array(
				'kriteria_id' => $kriteriaDinding->id,
				'nama' => 'Triplek',
				'nilai' => '2'
			));

		$nilaiDindingBeton = Nilai::create(array(
				'kriteria_id' => $kriteriaDinding->id,
				'nama' => 'Beton',
				'nilai' => '1'
			));

		$this->command->info("nilai masuk!");

		// link nilai dan warga

		$wargaUjang->nilai()->attach($nilaiDindingBeton->id);
		$wargaUjang->nilai()->attach($nilaiAtapGenteng->id);

		$wargaUdin->nilai()->attach($nilaiDindingTriplek->id);
		$wargaUdin->nilai()->attach($nilaiAtapDaun->id);
	}
}

 ?>