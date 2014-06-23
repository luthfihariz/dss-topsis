<?php

class Nilai extends Eloquent {

	protected $table = 'nilai';
	public $timestamps = false;
	protected $softDelete = false;

	public function kriteria()
	{
		return $this->belongsTo('Kriteria', 'kriteria_id');
	}

	public function warga()
	{
		return $this->belongsToMany('Warga', 'nilai_warga', 'nilai_id', 'warga_id');
	}

}