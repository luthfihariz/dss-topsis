<?php

class WargaTableSeeder extends Seeder{

	public function run(){

		DB::table('warga')->delete();		

		for ($i=0; $i < 100; $i++) { 
			
			$warga = new Warga();
			$warga->nama_krt = "Pak Anu".$i;
			$warga->no_kk = "N0KK0123".$i;
			$warga->no_kps = "N0KPS0321".$i;
			$warga->nama_pasangan_krt = "Bu Anu".$i;
			$warga->jml_anggota_keluarga = rand(2,10);
			$warga->propinsi = "Jawa Tengah";
			$warga->kabupaten_kota = "Brebes";
			$warga->kelurahan_desa = "Pulosari";
			$warga->rt = rand(1,25);
			$warga->rw = rand(1,15);
			$warga->alamat = "Jl. Jalan Sore";
			$warga->kode_pos = "150012";
			$warga->save();

			
			$lowerRandomRange = 25;
			$upperRandomRange = 28;
			for ($j=0; $j<14; $j++) {
				
				$nilai_id = rand($lowerRandomRange,$upperRandomRange);

				$this->command->info("kriteria ke : ".($j+1));
				$this->command->info("nilai : ".$nilai_id);
				
				$warga->nilai()->attach($nilai_id);
				
				$lowerRandomRange = $upperRandomRange+1;
				$upperRandomRange = $lowerRandomRange+3;
			}			

		}

	}

}