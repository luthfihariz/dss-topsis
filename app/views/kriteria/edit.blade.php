@extends('layout')

@section('content')

<h1>Edit Kriteria</h1>

<!-- if there are creation errors, they will show here -->
	{{ HTML::ul($errors->all()) }}

	{{ Form::model($kriteria, array('route' => array('kriteria.update', $kriteria->id), 'method' => 'PUT')) }}

		<div class="form-group">
			{{ Form::label('nama', 'Variabel Kemiskinan') }}
			{{ Form::text('nama', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('bobot', 'Bobot') }}
			{{ Form::input('number','bobot', null, array('class' => 'form-control')) }}
		</div>

		@foreach ($kriteria->nilai as $key => $nilai)
			<div class="form-group">
				{{ Form::label('nilai'.($key+1), 'Kategori '.($key+1)) }}
				{{ Form::text('nilai'.($key+1), $nilai->nama , array('class' => 'form-control')) }}
			</div>
		@endforeach
		

		<!-- <div class="form-group">
			{{ Form::label('nilai1', 'Nilai 2') }}
			{{ Form::text('nilai2', null, array('class' => 'form-control')) }}
		</div>		

		<div class="form-group">
			{{ Form::label('nilai1', 'Nilai 3') }}
			{{ Form::text('nilai3', null, array('class' => 'form-control')) }}
		</div>		 -->

		{{ Form::submit('Perbaharui', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}


@stop