<?php

class WargaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$warga = Warga::paginate(10);
		$kriteria = Kriteria::all();
		return View::make('warga.index')->with('semuaWarga', $warga)->with('kriteria', $kriteria);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$kriteria = Kriteria::all();
		return View::make('warga.create')->with('kriteria', $kriteria);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'nama_krt' => 'required',
			'no_kk' => 'required|unique:warga',
			'nama_pasangan_krt' => 'required',
			'jml_anggota_keluarga' => 'required|numeric|min:1',
			'kabupaten_kota' => 'required',
			'kelurahan_desa' => 'required',
			'rt' => 'required',
			'rw' => 'required',
			'kode_pos' => 'required',
			'alamat' => 'required',			
			);

		$kriteria = Kriteria::all();
		$message = array();
		foreach ($kriteria as $krit) {
			$rules = array_merge($rules, array('k'.$krit->id => 'required|regex:/^n/'));
			$message = array_merge($message, array('k'.$krit->id.'.regex' => 'Pilih salah satu kriteria '.$krit->nama.'.'));
		}

		$validator = Validator::make(Input::all(), $rules, $message);

		if($validator->fails()){
			return Redirect::to('warga/create')
			->withErrors($validator)
			->withInput(Input::except('password'));
		}else{
			$warga = new Warga();
			$warga->nama_krt = Input::get('nama_krt');
			$warga->no_kk = Input::get('no_kk');
			$warga->no_kps = Input::get('no_kps');
			$warga->nama_pasangan_krt = Input::get('nama_pasangan_krt');
			$warga->jml_anggota_keluarga = Input::get('jml_anggota_keluarga');
			$warga->propinsi = Input::get('propinsi');
			$warga->kabupaten_kota = Input::get('kabupaten_kota');
			$warga->kelurahan_desa = Input::get('kelurahan_desa');
			$warga->rt = Input::get('rt');
			$warga->rw = Input::get('rw');
			$warga->alamat = Input::get('alamat');
			$warga->kode_pos = Input::get('kode_pos');
			$warga->save();
			
			foreach ($kriteria as $krit) {
				$nilai_id = substr(Input::get("k".$krit->id),1);
				$warga->nilai()->attach($nilai_id);
			}

			//redirect
			Session::flash('message', 'Berhasil menambahkan data warga baru');
			return Redirect::to('warga');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$warga = Warga::find($id);
		return View::make('warga.show')->with('warga', $warga);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$warga = Warga::find($id);
		$kriteria = Kriteria::all();
		return View::make('warga.edit')
		->with('warga', $warga)
		->with('kriteria', $kriteria);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'nama_krt' => 'required',
			'no_kk' => 'required',
			'nama_pasangan_krt' => 'required',
			'jml_anggota_keluarga' => 'required|numeric|min:1',
			'kabupaten_kota' => 'required',
			'kelurahan_desa' => 'required',
			'rt' => 'required',
			'rw' => 'required',
			'kode_pos' => 'required',
			'alamat' => 'required',	
			);

		$kriteria = Kriteria::all();
		$message = array();
		foreach ($kriteria as $krit) {
			$rules = array_merge($rules, array('k'.$krit->id => 'required|regex:/^n/'));
			$message = array_merge($message, array('k'.$krit->id.'.regex' => 'Pilih salah satu kriteria '.$krit->nama.'.'));
		}		

		$validator = Validator::make(Input::all(), $rules, $message);


		if($validator->fails()){
			return Redirect::to('warga/'.$id.'/edit')
			->withErrors($validator)
			->withInput(Input::except('password'));
		}else{

			$warga = Warga::find($id);
			$warga->nama_krt = Input::get('nama_krt');
			$warga->no_kk = Input::get('no_kk');
			$warga->no_kps = Input::get('no_kps');
			$warga->nama_pasangan_krt = Input::get('nama_pasangan_krt');
			$warga->jml_anggota_keluarga = Input::get('jml_anggota_keluarga');
			$warga->propinsi = Input::get('propinsi');
			$warga->kabupaten_kota = Input::get('kabupaten_kota');
			$warga->kelurahan_desa = Input::get('kelurahan_desa');
			$warga->rt = Input::get('rt');
			$warga->rw = Input::get('rw');
			$warga->alamat = Input::get('alamat');
			$warga->kode_pos = Input::get('kode_pos');
			$warga->save();
			
			//remove old reference			
			foreach ($warga->nilai as $nilai) {				
				$warga->nilai()->detach($nilai->id);				
			}

			//Update
			foreach ($kriteria as $krit) {			
				$newNilaiId = substr(Input::get('k'.$krit->id),1);
				$warga->nilai()->attach($newNilaiId);
			}			

			//redirect
			Session::flash('message', 'Berhasil perbaharui data warga.');
			return Redirect::to('warga');
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
		if(Request::ajax()){
			//delete
			$warga = Warga::find($id);
			$warga->delete();

			return "Success";
		}
	}

}
