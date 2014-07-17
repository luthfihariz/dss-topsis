@extends('layout')
@section('content')

<script src='js/pdfmake.min.js'></script>
<script src='js/vfs_fonts.js'></script>
<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
<div class="col-md-12">
	<h2 class="page-header">Dashboard</h2>
	<div class="row">	
		<div class="col-md-8">												

			<p class="pull-right">
				<button type="button" class="btn btn-primary" id="calculate">Perbaharui Kalkulasi</button>
			</p>
			<p class="pull-left">
				Terakhir dilakukan kalkulasi pada : <b>{{$latest_updated->value}}</b>
			</p>

			<div class="clear"></div>
			@if(count($citizens) < $quota->value)
				<div class="alert alert-warning">
  				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
  					Terdapat <b>{{ ($quota->value - count($citizens)) }}</b> kuota raskin belum terbagi. Perbaharui kalkulasi untuk memutakhirkan data.
	    		</div>
			@endif
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-user fa-fw"></i> <b>Berhak Raskin</b>

					<div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#" id="report">Cetak Laporan</a>
                                        </li>
                                        <li><a href="{{URL::to('tickets')}}">Cetak Tiket</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

				</div>
				<div class="panel-body" id="result-container">
					
					<table class="table table-striped table-bordered table-hover" id="result">
						<thead>
							<tr>
								<td>No</td>
								<td>Nama KRT</td>
								<td>Nomor KK</td>
								<td>Nomor KPS</td>
								<td>Nama Pasangan KRT</td>
								<td>Bobot Kelayakan</td>
							</tr>		
						</thead>
						<tbody>
							@foreach($citizens as $key => $citizen)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$citizen['nama_krt']}}</td>
								<td>{{$citizen['no_kk']}}</td>
								<td>{{$citizen['no_kps']}}</td>
								<td>{{$citizen['nama_pasangan_krt']}}</td>
								<td>{{$citizen['solution']}}</td>
							</tr>							
							@endforeach
						</tbody>
					</table>
				</div>					
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Tidak Dikalkulasi</div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" id="uncalculated">
						<thead>
							<tr>
								<td>No</td>
								<td>Nama KRT</td>
								<td>Nomor KK</td>
								<td>Nomor KPS</td>
								<td>Nama Pasangan KRT</td>
							</tr>		
						</thead>
						<tbody>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-bar-chart-o fa-fw"></i> Pembagian Raskin
				</div>
				<div class="panel-body">
					<div id="morris-donut-chart"></div>
				</div>
				<!-- /.panel-body -->
			</div>
		</div>
	</div>
</div>

<!-- Page-Level Plugin Scripts - Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

<script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
<script src="js/plugins/morris/morris.js"></script>



<script type="text/javascript">
		
	var quota = "{{$quota->value}}";
	var startTime = new Date().getTime();
	var dataTable;	

	Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Berhak Raskin",
            value: '{{$quota->value}}'
        }, {
            label: "Tidak Berhak Raskin",
            value: '{{($numOfCitizen - $quota->value)}}'
        }],
        resize: true
    });

    jQuery("#report").click(function(){
    	
    	printReport(null);
    	/*jQuery.ajax({
			url : "{{ URL::to('getData') }}",
			type : "GET",
			beforeSend: function(data){
				setLoader(true);
				jQuery("#result tbody").html("");
			},
			success : function(data){				
				console.log("starting calculation... size : "+data.calculated.length);
				result = doTopsis(data.calculated);
				console.log("updating solution...");
				updateSolution(result);
				console.log("showing result..");
				showTopsisResult(result);
				printReport(result);
				setLoader(false);
			},
			error: function(data){
				console.log(data);
			}		
		});*/
    	
    });

    function printReport(data){
    	console.log("print report");
    	/*var pdf = new jsPDF('p','pt','letter');*/
    	/*html = "<html><head></head><body>"
    	var html = "<h1>Sistem Pendukung Keputusan Kelayakan Penerima Bantuan RASKIN asdjajshgjasdg jasdhkahsdkas djashdkjahskda</h1>";
    	html += "<table style='width:100%'><colgroup><colwidth='9%'><colwidth='13%'><colwidth='13%'> <colwidth='13%'> <colwidth='13%'> <colwidth='13%'> <colwidth='13%'> <colwidth='13%'> </colgroup>";
    	html += "<thead><tr><th>No</th><th>Nomor KK</th><th>Nama KRT</th><th>Nama Pasangan KRT</th><th>Kelurahan/Desa</th><th>RT</th><th>RW</th><th>Bobot Kelayakan</th></tr></thead><tbody>";
		$.each(data, function(index, singleData){
			html += "<tr>";
			html += "<td>"+(index+1)+"</td>";
			html += "<td>"+(singleData.no_kk)+"</td>";
			html += "<td>"+(singleData.nama_krt)+"</td>";
			html += "<td>"+(singleData.nama_pasangan_krt)+"</td>";
			html += "<td>"+(singleData.kelurahan_desa)+"</td>";			
			html += "<td>"+(singleData.rt)+"</td>";
			html += "<td>"+(singleData.rw)+"</td>";
			html += "<td>"+(singleData.solution)+"</td>";
			html += "</tr>";
		});
		html += "</tbody></table></body></html>"	*/
		
		var fonts = {
			Roboto: {
				normal: 'fonts/Roboto-Regular.ttf',
				bold: 'fonts/Roboto-Medium.ttf',
				italics: 'fonts/Roboto-Italic.ttf',
				bolditalics: 'fonts/Roboto-Italic.ttf'
			}
		};		

		var docDefinition = {
			content: [
				'First paragraph',
				'Another paragraph, this time a little bit longer to make sure, this line will be divided into at least two lines'
			]
		};

		pdfMake.createPdf(docDefinition).download('asd.pdf');

    }

	jQuery("#calculate").click(function(){		
		jQuery.ajax({
			url : "{{ URL::to('getData') }}",
			type : "GET",
			beforeSend: function(data){
				setLoader(true);
				jQuery("#result tbody").html("");
			},
			success : function(data){				
				console.log("starting calculation... size : "+data.calculated.length);
				result = doTopsis(data.calculated);
				console.log("updating solution...");
				updateSolution(result);
				console.log("showing result..");
				showTopsisResult(result);
				setLoader(false);
			},
			error: function(data){
				console.log(data);
			}		
		});
	});

	
	function doTopsis(data){

		var startTime = new Date().getTime();

		/*
		1. Kuadrat dari nilai pada variable kemiskinan masing-masing warga
		*/
		var squaredRateMatrix = {};
		data.forEach(function(singleData){
			var no_kk = singleData.no_kk;
			if(no_kk in squaredRateMatrix == false){
				squaredRateMatrix[no_kk] = {};
			}
			singleData.nilai.forEach(function(rate){
				squaredRate = rate.nilai * rate.nilai;
				squaredRateMatrix[no_kk][rate.kriteria] = squaredRate;				
			});
		});

		/*
		2. Jumlah kuadrat dan akar dari nilai pada masing-masing variable
		*/
		var sumOfRateCriterias = {};
		$.each(squaredRateMatrix, function(index, eachCitizenSquaredRate){
			$.each(eachCitizenSquaredRate, function(index, squaredRate){
				if(index in sumOfRateCriterias == false){
					sumOfRateCriterias[index] = 0;
				}
				sumOfRateCriterias[index] += squaredRate;
			});
		});
		$.each(sumOfRateCriterias, function(index, sumOfEachCriteria){
			sumOfRateCriterias[index] = Math.sqrt(sumOfEachCriteria);
		});

		var checkPointOne = new Date().getTime();
		console.log("step 1 - 2 : "+(checkPointOne - startTime));

		/*
		3. Normalisasi (pembagian nilai pada setiap variabel dengan jumlah kuadrat) 
		dan pengalian nilai normalisasi dengan bobot
		*/
		var normalizedWeightedCitizenRates = {};
		$.each(data, function(index, citizen){
			var no_kk = citizen.no_kk;
			if(no_kk in normalizedWeightedCitizenRates == false){
				normalizedWeightedCitizenRates[no_kk] = {};
			}
			$.each(citizen.nilai, function(index, rate){
				normalizedWeightedCitizenRates[no_kk][rate.kriteria] = 
				rate.nilai/sumOfRateCriterias[rate.kriteria] * rate.bobot;
			});
		});

		var checkPointTwo = new Date().getTime();		
		console.log("step 1 - 3 : "+(checkPointTwo - startTime));

		updateProgressBar("60%");

		/*
		4a. Putar dimensi matriks, untuk mendapatkan nilai terendah dan 
		tertinggi pada masing-masing kriteria
		*/
		var swiveledMatrix = {};
		$.each(normalizedWeightedCitizenRates, function(noKk, singleCitizenRate){
			$.each(singleCitizenRate, function(rateIndex, singleRate){
				if(rateIndex in swiveledMatrix == false){
					swiveledMatrix[rateIndex] = [];
				}
				swiveledMatrix[rateIndex].push(singleRate);
			});
		});

		/*
		4b. Mendapatkan nilai terendah (ideal negative) dan tertinggi (ideal positive) 
		dari masing-masing kriteria
		*/
		var idealPositive = {};
		var idealNegative = {};
		$.each(swiveledMatrix, function(criteriaName, rateInCitizens){
			idealPositive[criteriaName] = Math.max.apply(Math, rateInCitizens);
			idealNegative[criteriaName] = Math.min.apply(Math, rateInCitizens);
		});

		var checkPointThree = new Date().getTime();		
		console.log("step 1 - 4 : "+(checkPointThree - startTime));
	
		/*
		5. Menghitung separasi nilai setiap warga dengan ideal positive dan negative
		*/
		var positiveDistanceOfCitizens = {};
		var negativeDistanceOfCitizens = {};
		$.each(normalizedWeightedCitizenRates, function(noKk, singleCitizenRate){
			if(noKk in positiveDistanceOfCitizens == false){
				positiveDistanceOfCitizens[noKk] = 0;
			}
			if(noKk in negativeDistanceOfCitizens == false){
				negativeDistanceOfCitizens[noKk] = 0;
			}
			$.each(singleCitizenRate, function(rateIndex, singleRate){
				positiveDistanceOfCitizens[noKk] += Math.pow(singleRate - idealPositive[rateIndex], 2);
				negativeDistanceOfCitizens[noKk] += Math.pow(singleRate - idealNegative[rateIndex], 2);
			});
		});

		updateProgressBar("80%");

		var checkPointFour = new Date().getTime();		
		console.log("step 1 - 5 : "+(checkPointFour - startTime));

		/*
		6. Menghitung akar kuadrat separasi nilai dan menghitung nilai akhir masing2 warga 
		(kedekatan relatif terhadap solusi ideal)
		*/
		var proximityOfIdealSolution = {};
		$.each(normalizedWeightedCitizenRates, function(noKk, singleCitizenRate){
			positiveDistanceOfCitizens[noKk] = Math.sqrt(positiveDistanceOfCitizens[noKk]);
			negativeDistanceOfCitizens[noKk] = Math.sqrt(negativeDistanceOfCitizens[noKk]);

			if(noKk in proximityOfIdealSolution == false){
				proximityOfIdealSolution[noKk] = 0.0;
			}
			proximityOfIdealSolution[noKk] = negativeDistanceOfCitizens[noKk]/
			(positiveDistanceOfCitizens[noKk]+negativeDistanceOfCitizens[noKk]);
		})
		

		$.each(data, function(index, singleCitizen){
			singleCitizen['solution'] = proximityOfIdealSolution[singleCitizen.no_kk];
		});

		data.sort(function(a,b){
			if(a.solution < b.solution) return 1
			if(a.solution > b.solution) return -1
			return 0
		});

		var checkPointFive = new Date().getTime();		
		console.log("step 1 - Finish : "+(checkPointFive - startTime));
		
		var result = data.slice(0,parseInt(quota));
		console.log(result);
		return result;
	}

	function getSumOfRateCriterias(data){

		/*
		1. Kuadrat dari nilai pada variable kemiskinan masing-masing warga
		*/
		var squaredRateMatrix = {};
		data.forEach(function(singleData){
			var no_kk = singleData.no_kk;
			if(no_kk in squaredRateMatrix == false){
				squaredRateMatrix[no_kk] = {};
			}
			singleData.nilai.forEach(function(rate){
				squaredRate = rate.nilai * rate.nilai;
				squaredRateMatrix[no_kk][rate.kriteria] = squaredRate;				
			});
		});

		/*
		2. Jumlah kuadrat dan akar dari nilai pada masing-masing variable
		*/
		var sumOfRateCriterias = {};
		$.each(squaredRateMatrix, function(index, eachCitizenSquaredRate){
			$.each(eachCitizenSquaredRate, function(index, squaredRate){
				if(index in sumOfRateCriterias == false){
					sumOfRateCriterias[index] = 0;
				}
				sumOfRateCriterias[index] += squaredRate;
			});
		});
		$.each(sumOfRateCriterias, function(index, sumOfEachCriteria){
			sumOfRateCriterias[index] = Math.sqrt(sumOfEachCriteria);
		});
		

		return sumOfRateCriterias;
	}

	function showTopsisResult(result){
		var html = "";		
		$.each(result, function(index, singleCitizen){
			html += "<tr>"+
						"<td>"+(index+1)+"</td>"+
						"<td>"+singleCitizen.nama_krt+"</td>"+
						"<td>"+singleCitizen.no_kk+"</td>"+
						"<td>"+singleCitizen.no_kps+"</td>"+
						"<td>"+singleCitizen.nama_pasangan_krt+"</td>"+
						"<td>"+singleCitizen.solution+"</td>"+
					"</tr>";
		});
		jQuery("#result tbody").html(html);
		//dataTable = jQuery("#result").DataTable({"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
			
		updateProgressBar("100%");		
	}

	function updateSolution(result){
		var sentResult = [];
		$.each(result, function(index, citizen){			
			var single = {"id":citizen.id,"solution":citizen.solution};
			console.log(single);
			sentResult.push(single);
		});
		jQuery.ajax({
			url: "{{ URL::to('updateSolution') }}",
			type: "POST",
			data: { solutions: sentResult },
			dataType: 'json',
			success: function(data){
				console.log(data.responseText);
			},
			error: function(data){
				console.log(data.responseText);
			}
		});
	}

	function showUncalculatedData(data){
		if(data.length > 0){
			var html = "";
			$.each(result, function(index, singleCitizen){
				html += "<tr>"+
							"<td>"+(index+1)+"</td>"+
							"<td>"+singleCitizen.nama_krt+"</td>"+
							"<td>"+singleCitizen.no_kk+"</td>"+
							"<td>"+singleCitizen.no_kps+"</td>"+
							"<td>"+singleCitizen.nama_pasangan_krt+"</td>"+
						"</tr>";
			});
			jQuery("#uncalculated tbody").html(html);
			jQuery("#uncalculated").dataTable();
		}			
	}

	function setLoader(isShown){
		if(isShown){
			jQuery("#loader").show();
			jQuery("#loader").text("Proses ini akan memakan waktu beberapa menit.");
		}else{
			jQuery("#loader").hide();
		}
	}

	function updateProgressBar(progress){
		jQuery("#progressbar").css({width:progress});		
		if(progress=="100%"){
			jQuery("#barcontainer").removeClass('active').delay(500).fadeOut(100);
		}else if(progress="0%"){
			jQuery("#barcontainer").addClass('active').delay(500).fadeIn(100);
		}		
	}
	
</script>
@stop

