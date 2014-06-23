<?php

class Kriteria extends Eloquent {

	protected $table = 'kriteria';
	public $timestamps = false;
	protected $softDelete = false;

	public function nilai()
	{
		return $this->hasMany('Nilai', 'kriteria_id');
	}

}