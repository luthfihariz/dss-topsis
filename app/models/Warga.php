<?php

class Warga extends Eloquent {

	protected $table = 'warga';
	public $timestamps = true;
	protected $softDelete = false;
	protected $with = array('nilai.kriteria');

	public function nilai()
	{
		return $this->belongsToMany('Nilai', 'nilai_warga', 'warga_id', 'nilai_id');
	}
}