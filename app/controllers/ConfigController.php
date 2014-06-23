<?php

class ConfigController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$configs = Konfigurasi::all();
		return View::make('config.index')->with('configs',$configs);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$rules = array(
			'max_citizen' => 'required|numeric|min:1'
		);
		$messages = array(
			'max_citizen.required' => 'Field kuota penerima raskin tidak boleh kosong.',
			'max_citizen.numeric' => 'Format kuota penerima raskin harus dalam bentuk angka.',
			'max_citizen.min' => 'Kuota penerima raskin minimal :min.'
		);
		$validator = Validator::make(Input::all(), $rules, $messages);

		if($validator->fails()){
			return Redirect::to('config')
			->withErrors($validator)
			->withInput(Input::except('password'));
		}else{
			$configs = Konfigurasi::all();
			foreach ($configs as $key => $config) {					
				$config->value = Input::get($config->key);
				$config->save();
			}
			Session::flash('message', 'Konfigurasi telah disimpan.');
			return Redirect::to('config');
		}	
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
