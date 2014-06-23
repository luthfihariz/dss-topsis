<?php 

class Konfigurasi extends Eloquent {

	protected $table = 'configs';
	public $timestamps = true;
	protected $softDelete = false;	
}