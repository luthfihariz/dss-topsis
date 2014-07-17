<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		return View::make('user.index')->with('users', $users);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('user.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'username' => 'required|min:4|unique:users',
			'email' => 'email|required|unique:users',
			'password' => 'required|min:4',
			'role' => 'required|numeric'
		);

		$messages = array(
			'role.numeric' => 'Pilih salah satu peranan pengguna.'
		);

		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if($validator->fails()){
			return Redirect::to('user/create')
			->withErrors($validator)
			->withInput(Input::except('password'));
		}else{
			$user = new User();
			$user->username = Input::get('username');
			$user->password = Hash::make(Input::get('password'));
			$user->email = Input::get('email');
			$user->roles = Input::get('role');
			$user->save();

			//redirect
			Session::flash('message', 'Berhasil menambahkan pengguna baru.');
			return Redirect::to('user');
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
		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		return View::make('user.edit')->with('user', $user);
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
			'username' => 'required|min:4',
			'email' => 'email|required',
			'role' => 'required|numeric'
		);

		$messages = array(
			'role.numeric' => 'Pilih salah satu peranan pengguna.'
		);

		$validator = Validator::make(Input::all(), $rules, $messages);
		
		if($validator->fails()){
			return Redirect::to('user/'.$id.'/edit')
			->withErrors($validator)
			->withInput(Input::except('password'));
		}else{
			$user = User::find($id);
			$user->email = Input::get('email');
			$user->username = Input::get('username');
			$user->roles = Input::get('role');
			$user->save();

			//redirect
			Session::flash('message', 'Data pengguna berhasil disimpan.');
			return Redirect::to('user');
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
		if(Request::ajax())	{
			$user = User::find($id);
			$user->delete();

			return "Success";
		}
	}


}