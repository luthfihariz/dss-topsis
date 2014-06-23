@extends('layout')
@section('content')


<div class="col-md-12">
	<h2 class="page-header">Tambah Pengguna</h2>

	{{ HTML::ul($errors->all()) }}

	{{ Form::open(array('url' => 'user')) }}

	<div class="form-group">
		{{ Form::label('username', 'Username') }}
		{{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Password') }}
		{{ Form::input('password','password', Input::old('password'), array('class' => 'form-control')) }}
	</div>	

	<div class="form-group">
		{{ Form::label('Peranan', 'Peranan') }}
		{{ Form::select('role', array('default' => 'Pilih Peranan', 1 => 'Super Admin', 2 => 'Admin', 3 => 'Staff'),0, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Simpan', array('class'=>'btn btn-primary')) }}

	{{ Form::close() }}


</div>


@stop
