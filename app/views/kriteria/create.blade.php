@extends('layout')

@section('content')

<div class="col-md-12">
<h2 class="page-header">Tambah Kriteria Baru</h1>

<!-- if there are creation errors, they will show here -->
	{{ HTML::ul($errors->all()) }}

	{{ Form::open(array('url' => 'kriteria')) }}

		<div class="form-group">
			{{ Form::label('nama', 'Variable Kemiskinan') }}
			{{ Form::text('nama', Input::old('nama'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('bobot', 'Bobot') }}
			{{ Form::input('number','bobot', Input::old('bobot'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('nilai1', 'Kategori 1') }}
			{{ Form::text('nilai1', Input::old('nilai1'), array('class' => 'form-control')) }}
			<p class="help-block">Kelas tertinggi dalam kriteria. 
				Contoh : Jika kriterianya adalah Dinding Rumah dan kategori Beton adalah yang terbaik, maka isi bagian ini dengan Beton.</p>
		</div>		

		<div class="form-group">
			{{ Form::label('nilai2', 'Kategori 2') }}
			{{ Form::text('nilai2', Input::old('nilai2'), array('class' => 'form-control')) }}
		</div>		

		<div class="form-group">
			{{ Form::label('nilai3', 'Kategori 3') }}
			{{ Form::text('nilai3', Input::old('nilai3'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('nilai4', 'Kategori 4') }}
			{{ Form::text('nilai4', Input::old('nilai4'), array('class' => 'form-control')) }}
			<p class="help-block">Kelas terendah dalam kriteria.</p>
		</div>

		{{ Form::submit('Simpan', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
</div>
@stop