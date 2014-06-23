@extends('layout')
@section('content')

<div class="col-md-12">

	<h2 class="page-header">Edit Pengguna</h2>

	{{ HTML::ul($errors->all()) }}
	{{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT')) }}


	<div class="form-group">
		{{ Form::label('username', 'Username') }}
		{{ Form::text('username', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::text('email', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('Peranan', 'Peranan') }}
		{{ Form::select('role', array('default' => 'Pilih Peranan', 1 => 'Super Admin', 2 => 'Admin', 3 => 'Staff'), $user->roles, array('class' => 'form-control')) }}
	</div>

	{{ Form::submit('Perbaharui', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}

</div>

@stop