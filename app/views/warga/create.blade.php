@extends('layout')
@section('content')
<div class="col-md-12">

	<h2 class="page-header">Data Warga Baru</h1>

<!-- if there are creation errors, they will show here -->
	{{ HTML::ul($errors->all()) }}

	{{ Form::open(array('url' => 'warga')) }}
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Data Utama</div>
				<div class="panel-body">
					<div class="form-group">
						{{ Form::label('nama', 'Nama Kepala Rumah Tangga (KRT)') }}
						{{ Form::text('nama_krt', Input::old('nama_krt'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('no_kk', 'No Kartu Keluarga') }}
						{{ Form::text('no_kk', Input::old('no_kk'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('no_kps', 'No Kartu Perlindungan Sosial (KPS)') }}
						{{ Form::text('no_kps', Input::old('no_kps'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('nama_pasangan_krt', 'Nama Pasangan KRT') }}
						{{ Form::text('nama_pasangan_krt', Input::old('no_kk'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('jml_anggota_keluarga', 'Jumlah Anggota Keluarga') }}
						{{ Form::input('number', 'jml_anggota_keluarga', Input::old('jml_anggota_keluarga'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('propinsi', 'Propinsi') }}
						{{ Form::text('propinsi', Input::old('propinsi'), array('class' => 'form-control')) }}
					</div>					

					<div class="form-group">
						{{ Form::label('kabupaten_kota', 'Kabupaten / Kota') }}
						{{ Form::text('kabupaten_kota', Input::old('kabupaten_kota'), array('class' => 'form-control')) }}
					</div>					

					<div class="form-group">
						{{ Form::label('kelurahan_desa', 'Kelurahan / Desa') }}
						{{ Form::text('kelurahan_desa', Input::old('kelurahan_desa'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('rt', 'RT') }}
						{{ Form::text('rt', Input::old('rt'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('rw', 'RW') }}
						{{ Form::text('rw', Input::old('rw'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('kode_pos', 'Kode Pos') }}
						{{ Form::text('kode_pos', Input::old('kode_pos'), array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						{{ Form::label('alamat', 'Alamat Lengkap') }}
						{{ Form::text('alamat', Input::old('alamat'), array('class' => 'form-control')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Kriteria Kemiskinan</div>
				<div class="panel-body">
				@foreach($kriteria as $krit)
					<?php $values = array('0'=> 'Pilih Parameter'); ?>
					@foreach($krit->nilai as $nilai)
						<?php 
							$option = "n".$nilai->id;
							$values = array_merge($values, array($option => $nilai->nama)); 
						?>
					@endforeach
					<div class="form-group">
						{{ Form::label($krit->nama, $krit->nama) }}				
						{{ Form::select('k'.$krit->id, $values, Input::old($krit->nama), array('class' => 'form-control')) }}
					</div>			
				@endforeach
				</div>
			</div>
		</div>

		<div class="col-md-12">
		{{ Form::submit('Simpan', array('class' => 'btn btn-primary pull-right')) }}
		{{ Form::close() }}
		</div>
	</div>
</div>
@stop