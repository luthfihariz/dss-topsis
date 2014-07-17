<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SPK Raskin</title>

    <!-- Core CSS - Include with every page -->
    <link href="{{ URL::to('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('font-awesome/css/font-awesome.css') }}" rel="stylesheet">    

    <!-- SB Admin CSS - Include with every page -->
    <link href="{{ URL::to('css/sb-admin.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ URL::to('css/style.css') }}">
</head>
<body>
    <div class="wholepageloader" id="loader" style="display:none"></div>
	<div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Sistem Penunjang Keputusan</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">                                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Selamat datang, {{ Auth::user()->username }} ({{ Auth::user()->roles }}) <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">                        
                        <li><a href="{{ URL::to('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="{{ URL::to('/') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>                        
                        <li>
                            <a href="{{ URL::to('warga') }}"><i class="fa fa-table fa-fw"></i> Data Warga</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('kriteria') }}"><i class="fa fa-edit fa-fw"></i> Kriteria</a>
                        </li>
                        @if(Auth::user()->roles == 1)
                        <li>
                            <a href="{{ URL::to('user') }}"><i class="fa fa-user fa-fw"></i> Pengguna</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('config') }}"><i class="fa fa-wrench fa-fw"></i> Konfigurasi</a>
                        </li>                   
                        @endif                
                        
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Core Scripts - Include with every page -->
        <script src="{{ URL::to('js/jquery-1.10.2.js') }}"></script>
        <script src="{{ URL::to('js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::to('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    
        <div id="page-wrapper">

            <div class="row">
				@yield('content')
			</div>
		</div>

	</div>

 

    <!-- SB Admin Scripts - Include with every page -->
    <script src="{{ URL::to('js/sb-admin.js') }}"></script>    

</body>
</html>
