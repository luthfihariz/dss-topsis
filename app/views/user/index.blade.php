@extends('layout')
@section('content')

<div class="col-md-12">

	<h3 class="page-header">Manajemen Pengguna</h3>
	<div class="pull-right">
		<p><a href="{{ URL::to('user/create') }}" type="button" class="btn btn-outline btn-success">+ Tambah Pengguna</a></p>
	</div>

	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td>No</td>
				<td>Username</td>
				<td>Email</td>
				<td>Peranan</td>
				<td>Aksi</td>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $key => $user)
			<tr>
				<td>{{ $key+1 }}</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->email }}</td>
				<td>
					<?php 

						switch ($user->roles) {
							case 1:
								echo "Super Admin";
								break;
							case 2:
								echo "Admin";
								break;
							case 3:
								echo "Staff";
								break;
							default:
								break;
						}

					 ?>

				</td>
				<td>					
					<div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Actions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">                            
                            <li><a href="{{ URL::to('user/' . $user->id . '/edit') }}">Edit</a>
                            </li>
                            <li><a href="#" class="deleteUser" key="{{ $user->id }}">Delete</a>
                            </li>
                        </ul>
                    </div>					
				</td>
			</tr>
			@endforeach
		</tbody>
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
				<p>Hapus data pengguna ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="deleteUserBtn" data-loading-text="Deleting...">Delete</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	
	jQuery('.deleteUser').click(function(){
		jQuery("#delModal").modal('show');
		var id = jQuery(this).attr("key");
		jQuery("#deleteUserBtn").attr("key", id);
	});

	jQuery('#deleteUserBtn').click(function(){
		var id = jQuery(this).attr("key");
		var url = "{{ URL::to('user') }}/"+id;
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
