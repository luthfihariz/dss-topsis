@extends('layout')

@section('content')
<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
<div class="col-md-12">
	<h2 class="page-header">Dashboard</h2>
	<div class="row">	
		<div class="col-md-8">						

			<div class="progress progress-striped active" id="barcontainer">
  				<div id="progressbar" class="progress-bar" role="progressbar" 
  				aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
			  	</div>
			</div>

			<p class="pull-right">
				<button type="button" class="btn btn-primary" id="calculate">Perbaharui Kalkulasi</button>
			</p>
			<p class="pull-left">
				Terakhir dilakukan kalkulasi pada : <b>{{$latest_updated->value}}</b>
			</p>
			<div class="clear"></div>
			
			<div class="panel panel-default">
				<div class="panel-heading">Berhak Raskin</div>
				<div class="panel-body">
					
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
							@foreach($calculatedCitizens as $key => $citizen)
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
							@foreach($unCalculatedCitizens as $key => $citizen)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$citizen['nama_krt']}}</td>
								<td>{{$citizen['no_kk']}}</td>
								<td>{{$citizen['no_kps']}}</td>
								<td>{{$citizen['nama_pasangan_krt']}}</td>
							</tr>							
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
				</div>
				<div class="panel-body">
					<div id="morris-donut-chart"></div>
					<a href="#" class="btn btn-default btn-block">View Details</a>
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
	var calculatedCitizens = '{{json_encode($calculatedCitizens)}}';	


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

	jQuery("#calculate").click(function(){
		jQuery("#result tbody").html("");
		jQuery.ajax({
			url : "{{ URL::to('getData') }}",
			type : "GET",			
			success : function(data){															
				console.log("starting calculation...");
				result = doTopsis(data.calculated);
				console.log("updating solution...");
				updateSolution(result);
				console.log("showing result..");
				showTopsisResult(result);				
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

	function updateProgressBar(progress){
		jQuery("#progressbar").css({width:progress});		
		if(progress=="100%"){
			jQuery("#barcontainer").removeClass('active').delay(500).fadeOut(100)
		}
		
	}
	
</script>
@stop

