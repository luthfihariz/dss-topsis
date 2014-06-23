@extends('layout')
@section('content')

<h3 class="page-header">Konfigurasi</h3>
	
	<div class="row">
	<div class="col-md-4">
		{{ HTML::ul($errors->all()) }}

		@if(Session::has('message'))
	    <div class="alert alert-info alert-dismissable">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        {{ Session::get('message') }}
	    </div>
		@endif

		{{ Form::open(array('url' => 'config/update', 'method' => 'put')) }}

		@foreach($configs as $config)
			<div class="form-group">
				{{ Form::label($config->key, $config->displayed_key) }}
				{{ Form::input('number', $config->key, $config->value, array('class' => 'form-control')) }}
			</div>
		@endforeach

		{{ Form::submit('Simpan', array('class' => 'btn btn-primary pull-right')) }}
	</div>
	</div>

@stop