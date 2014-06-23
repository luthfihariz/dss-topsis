@extends('layout')

@section('content')
	
	<h2>Detail Warga</h2>
	@if($warga)

		Nama KRT : {{$warga->nama_krt}}<br/>
		Nomor KK : {{$warga->no_kk}}<br/>
		Nomor KPS : {{$warga->no_kps}}<br/>
		Nama Pasangan KRT : {{$warga->nama_pasangan_krt}}<br/>
		Jumlah Tanggungan : {{$warga->jml_anggota_keluarga}}<br/>
		RT : {{$warga->rt}}<br/>
		RW : {{$warga->rw}}<br/>
		Kelurahan/Desa : {{$warga->kelurahan_desa}}<br/>
		Kabupaten/Kota : {{$warga->kabupaten_kota}}<br/>
		Propinsi : {{$warga->propinsi}}		<br/>
		Kode Pos : {{$warga->kode_pos}}
		<br/>

		@foreach($warga->nilai as $nilai)
			{{$nilai->kriteria->nama}} : <b>{{$nilai->nama}}</b> <br/>
		@endforeach

	@endif
@stop