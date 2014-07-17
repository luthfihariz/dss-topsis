<html>
<head>
	<title>Login</title>

	<!-- Core CSS - Include with every page -->
    <link href="{{ URL::to('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="{{ URL::to('css/sb-admin.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ URL::to('css/style.css') }}">

</head>
<body>
<div class="container" id="main">
<div class="row">
<div class="col-md-4 col-md-offset-4">
	<!-- if there are login errors, show them here -->
	{{ $errors->first('email') }}
	{{ $errors->first('password') }}
	
	<div class="panel panel-default">
		<div class="panel-heading">		
			<h2>Login</h2>
		</div>		
		<div class="panel-body">
		{{ Form::open(array('url' => 'login')) }}		
			<div class="form-group">
				{{ Form::label('username', 'Username') }}
				{{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('password', 'Password') }}
				{{ Form::password('password', array('class' => 'form-control')) }}
			</div>
			{{ Form::submit('Login', array('class'=>'btn btn-primary')) }}
		{{ Form::close() }}
		</div>

</div>
</div>
</div>
</body>
</html>

