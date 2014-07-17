<?php

class LoginController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('login.index');
	}


	public function doLogin()
	{
		$rules = array(
			'username' => 'required|min:4',
			'password' => 'required|min:4',
		);

		$validator = Validator::make(Input::all(), $rules);
		if($validator->fails()){
			return Redirect::to('login')
					->withErrors($validator)
					->withInput(Input::except('password'));
		}else{
			$userdata = array(
				'username' => Input::get('username'),
				'password' => Input::get('password')
				);

			if(Auth::attempt($userdata)){
				return Redirect::intended('/');
			}else{
				return Redirect::to('login')
						->withErrors(array('password' => 'Invalid username or password.'))
						->withInput(Input::except('password'));
			}
		}
	}

	public function doLogout()
	{
		Auth::logout();
		return Redirect::to('login');
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
	public function update($id)
	{
		//
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
