<?php

class UserTableSeeder extends Seeder{

	public function run(){

		DB::table('users')->delete();
		
		User::create(array(
			'username' => 'pakades',
			'email' => 'pakades@lurah.com',
			'password' => Hash::make('pakadesganteng')
			));

		User::create(array(
			'username' => 'stafflurah',
			'email' => 'staff@lurah.com',
			'password' => Hash::make('staffganteng')
			));
	}

}

?>