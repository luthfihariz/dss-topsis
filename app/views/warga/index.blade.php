@extends('layout')

@section('content')


<div class="col-md-12">
	
	<h2 class="page-header">Data Warga</h2>
	<div class="alert alert-info alert-dismissable" id="alert">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    	Data warga telah dihapus.
	</div>
	<b>Jumlah Warga : {{ $count }}</b>
	<div class="row">
		<div class="col-md-7">
			{{ $semuaWarga->links() }}

		</div>
		<div class="col-md-5">
			<div class="pull-right">
				<p><a href="{{ URL::to('warga/create') }}" type="button" class="btn btn-outline btn-success">+ Tambah Data Baru</a></p>
			</div>	
		</div>
	</div>

	<table class="table table-striped table-bordered table-hover" id="wargaTable">

		<thead>
			<tr>
				<td>No</td>
				<td>Nama KRT</td>
				<td>Nomor KK</td>
				<td>Nomor KPS</td>
				<td>Nama Pasangan KRT</td>
				<td>Kabupaten/Kota</td>
				<td>Kelurahan/Desa</td>
				<td>RT</td>
				<td>RW</td>
				<td>Aksi</td>
			</tr>		
		</thead>
		<tbody>

		@foreach($semuaWarga as $key => $warga)
			@if(count($kriteria) > count($warga->nilai))
				<tr class="danger">
			@else
				<tr>
			@endif
				<td>{{$key+1+(10*($semuaWarga->getCurrentPage()-1))}}</td>
				<td>{{$warga->nama_krt}}</td>
				<td>{{$warga->no_kk}}</td>
				<td>{{$warga->no_kps}}</td>
				<td>{{$warga->nama_pasangan_krt}}</td>
				<td>{{$warga->kabupaten_kota}}</td>
				<td>{{$warga->kelurahan_desa}}</td>
				<td>{{$warga->rt}}</td>
				<td>{{$warga->rw}}</td>
				<td>					
					<div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Actions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('warga/' . $warga->id) }}">Detail</a>
                            </li>
                            <li><a href="{{ URL::to('warga/' . $warga->id . '/edit') }}">Edit</a>
                            </li>
                            <li><a href="#" class="deleteWarga" key="{{ $warga->id }}">Delete</a>
                            </li>
                        </ul>
                    </div>					
				</td>
			</tr>
		@endforeach
		<tbody>
	</table>
</div>

<div class="modal fade" id="delModal" data-backdrop=static data-keyboard=true tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" id="close-btn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
			</div>
			<div class="modal-body">				
				<p>Hapus data warga ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="delWargaBtn" data-loading-text="Deleting...">Delete</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	
	jQuery(document).ready(function(){
		jQuery("#alert").hide();
	});

	jQuery('.deleteWarga').click(function(){
		console.log("delete!!!!!!");
		jQuery("#delModal").modal("show");
		var id = jQuery(this).attr("key");
		jQuery("#delWargaBtn").attr("key", id);
	});

	jQuery('#delWargaBtn').click(function(){
		var id = jQuery(this).attr("key");
		var url = "{{ URL::to('warga') }}/"+id;
		console.log("url : "+url);
		jQuery.ajax({
			url: url,
			type: "DELETE",
			success: function(data){
				console.log("ok "+data);
				location.reload();
				//jQuery("#alert").show();
			},
			error: function(data){
				console.log("error "+JSON.stringify(data));	
				location.reload();
			}
		});
	});

</script>
@stop