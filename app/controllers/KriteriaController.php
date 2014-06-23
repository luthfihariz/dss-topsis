<?php

class KriteriaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$allKriteria = Kriteria::all();
		return View::make('kriteria.list')->with('allKriteria', $allKriteria);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('kriteria.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'nama' => 'required',
			'bobot' => 'required|numeric',
			'nilai1' => 'required',
			'nilai2' => 'required',
			'nilai3' => 'required'
			);

		$validator = Validator::make(Input::all(), $rules);

		//process the storing
		if($validator->fails()){
			return Redirect::to('kriteria/create')
			->withErrors($validator)
			->withInput(Input::except('password'));
		}else{
			//all fields are valid
			$kriteria = new Kriteria();
			$kriteria->nama = Input::get('nama');
			$kriteria->bobot = Input::get('bobot');
			$kriteria->save();

			$nilai1 = new Nilai();
			$nilai1->kriteria_id = $kriteria->id;
			$nilai1->nama = Input::get('nilai1');
			$nilai1->nilai = 1;
			$nilai1->save();

			$nilai2 = new Nilai();
			$nilai2->kriteria_id = $kriteria->id;
			$nilai2->nama = Input::get('nilai2');
			$nilai2->nilai = 2;
			$nilai2->save();
			
			$nilai3 = new Nilai();
			$nilai3->kriteria_id = $kriteria->id;
			$nilai3->nama = Input::get('nilai3');
			$nilai3->nilai = 3;
			$nilai3->save();

			$nilai3 = new Nilai();
			$nilai3->kriteria_id = $kriteria->id;
			$nilai3->nama = Input::get('nilai4');
			$nilai3->nilai = 4;
			$nilai3->save();
			
			//redirect
			Session::flash('message', 'Berhasil menambahkan kriteria baru!');
			return Redirect::to('kriteria');
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
		$kriteria = Kriteria::find($id);
		return View::make('kriteria.edit')->with('kriteria', $kriteria);
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
			'nama' => 'required',
			'bobot' => 'required|numeric',
			'nilai1' => 'required',
			'nilai2' => 'required',
			'nilai3' => 'required'
			);

		$validator = Validator::make(Input::all(), $rules);

		//process the storing
		if($validator->fails()){
			return Redirect::to('kriteria/'.$id.'/edit')
			->withErrors($validator)
			->withInput(Input::except('password'));
		}else{
			//all fields are valid
			$kriteria = Kriteria::find($id);
			$kriteria->nama = Input::get('nama');
			$kriteria->bobot = Input::get('bobot');
			$kriteria->save();

			foreach ($kriteria->nilai as $key => $nilai) {
				$nilai->kriteria_id = $id;
				$nilai->nama = Input::get('nilai'.($key+1));
				$nilai->nilai = ($key+1);
				$nilai->save();
			}			
			
			//redirect
			Session::flash('message', 'Berhasil merubah kriteria baru!');
			return Redirect::to('kriteria');
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
			$kriteria = Kriteria::find($id);
			$kriteria->delete();

			return "Success";
		}
	}


}
