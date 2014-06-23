@extends('layout')

@section('content')

<div class="col-md-12">
<h2 class="page-header">Kriteria Warga</h2>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="pull-left">Kriteria Masyarakat Miskin</h4>
		<a class="btn btn-small btn-success pull-right" href="{{ URL::to('kriteria/create') }}">+</a>
		<div class="clear"></div>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Nomor</th>
					<th>Variable Kemiskinan</th>
					<th>Bobot</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($allKriteria as $key => $kriteria)
					<tr>
						<td>{{ $key+1 }}</td>
						<td>{{ $kriteria->nama }}</td>
						<td>{{ $kriteria->bobot }}</td>
						<td>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
	                            	Actions
	                            	<span class="caret"></span>
	                        	</button>
								<ul class="dropdown-menu" role="menu">	                            
		                            <li><a href="{{ URL::to('kriteria/' . $kriteria->id . '/edit') }}">Edit</a>
		                            </li>
		                            <li><a href="#" class="del-kriteria" key="{{ $kriteria->id }}">Delete</a>
		                            </li>
	                        	</ul>
                        	</div>		
						</td>
					</tr>
				@endforeach
			</tbody>
			</table>
	</div>
</div>

<div class="row">	
	@foreach ($allKriteria as $kriteria)
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h5>{{ $kriteria->nama }}</h5>
				</div>
				<div class="panel-body">
								
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Kondisi</th>
									<th>Nilai</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($kriteria->nilai as $nilai)						
								<tr>
									<td>{{ $nilai->nama }}</td>
									<td>{{ $nilai->nilai }}</td>
								</tr>
								@endforeach		
							</tbody>
						</table>

				</div>
			</div>
		</div>
	@endforeach
</div>
</div>

<div class="modal fade" id="delKritModal" data-backdrop=static data-keyboard=true tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" id="close-btn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
			</div>
			<div class="modal-body">				
				<p>Hapus data kriteria ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="delKritBtn" data-loading-text="Deleting...">Delete</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">

	jQuery(".del-kriteria").click(function(){
		jQuery("#delKritModal").modal("show");
		var id = jQuery(this).attr("key");
		jQuery("#delKritBtn").attr("key", id);
	});

	jQuery("#delKritBtn").click(function(){
		var id = jQuery(this).attr("key");
		var url = "{{ URL::to('kriteria') }}/"+id;
		console.log("url : "+url);
		jQuery.ajax({
			url: url,
			type: "DELETE",
			success: function(data){
				console.log("ok "+data);
				location.reload();
			},
			error: function(data){
				console.log("error "+JSON.stringify(data));	
				location.reload();
			}
		});
	});

</script>	

@stop