@extends('layout')

@section('content')
	
	<h2 class="page-header">Detail Warga</h2>
	@if($warga)
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
			<div class="panel-heading">Profil</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Nama Kepala Rumah Tangga (KRT)</label>
					<p class="form-control-static">{{$warga->nama_krt}}</p>
				</div>
				<div class="form-group">
					<label>Nama Pasangan KRT</label>
					<p class="form-control-static">{{$warga->nama_pasangan_krt}}</p>
				</div>
				<div class="form-group">
					<label>Nomor KK</label>
					<p class="form-control-static">{{$warga->no_kk}}</p>
				</div>
				<div class="form-group">
					<label>Nomor KPS</label>
					<p class="form-control-static">{{$warga->no_kps}}</p>
				</div>
				<div class="form-group">
					<label>Jumlah Tanggungan</label>
					<p class="form-control-static">{{$warga->jml_anggota_keluarga}}</p>
				</div>
				<div class="form-group">
					<label>Kelurahan/Desa</label>
					<p class="form-control-static">{{$warga->kelurahan_desa}}</p>
				</div>
				<div class="form-group">
					<label>Kabupaten/Kota</label>
					<p class="form-control-static">{{$warga->kabupaten_kota}}</p>
				</div>
				<div class="form-group">
					<label>Propinsi</label>
					<p class="form-control-static">{{$warga->propinsi}}</p>
				</div>		
				<div class="form-group">
					<label>RT</label>
					<p class="form-control-static">{{$warga->rt}}</p>
				</div>
				<div class="form-group">
					<label>RW</label>
					<p class="form-control-static">{{$warga->rw}}</p>
				</div>
				<div class="form-group">
					<label>Kode Pos</label>
					<p class="form-control-static">{{$warga->kode_pos}}</p>
				</div>
			</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
			<div class="panel-heading">Kriteria Kemiskinan</div>
			<div class="panel-body">
				@foreach($warga->nilai as $nilai)
				 <div class="form-group">
				 	<label>{{$nilai->kriteria->nama}}</label>
				 	<p class="form-control-static">{{$nilai->nama}}</p>
				 </div>
				@endforeach
			</div>
		</div>
	</div>
	@endif
@stop