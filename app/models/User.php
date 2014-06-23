<?php 

class User extends Eloquent{
	protected $table = 'users';
	public $timestamps = true;
	protected $softDelete = false;
}