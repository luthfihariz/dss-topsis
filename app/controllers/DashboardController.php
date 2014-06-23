<?php

class DashboardController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{		
		$quota = Konfigurasi::where('key', '=', 
			'max_citizen')->first();
		$latest_updated = Konfigurasi::where('key', '=', 
			'latest_topsis_calculation')->first();	

		$data = $this->getData();

		return View::make('index')
		->with('quota', $quota)
		->with('latest_updated', $latest_updated)
		->with('numOfCitizen', $data['numOfCitizen'])
		->with('calculatedCitizens', $data['calculated'])
		->with('unCalculatedCitizens', $data['uncalculated']);
	}

	public function getData(){
		
		$warga = Warga::where('solution','>','0.1');
		$numOfKriteria = Kriteria::all()->count();
		$numOfWarga = count($warga);

		$inArrayAllWarga = Array();		
		foreach ($warga as $i => $war) {			
			$inArrayAllNilaiEachWarga = Array();
			foreach ($war->nilai as $j => $nilai) {
				$inArrayNilai = $nilai->toArray();
				unset($inArrayNilai['pivot']);
				$inArrayNilai['kriteria'] = $nilai->kriteria->nama;
				$inArrayNilai['bobot'] = $nilai->kriteria->bobot;
				array_push($inArrayAllNilaiEachWarga, $inArrayNilai);
			}			
			$inArrayWarga = $war->toArray();			
			$inArrayWarga['nilai'] = $inArrayAllNilaiEachWarga;
			array_push($inArrayAllWarga, $inArrayWarga);
		}				

		$calculatedData = Array();
		$unCalculatedData = Array();	
					
		//separate
		foreach ($inArrayAllWarga as $key => $war) {
			if($numOfKriteria == count($war['nilai'])){
				array_push($calculatedData, $war);
			}else{
				array_push($unCalculatedData, $war);
			}
		}		


		return array(
				'numOfCitizen' => $numOfWarga,
				'calculated' => $calculatedData,
				'uncalculated' => $unCalculatedData
				);
	}

	
	public function updateSolution(){
		$solutions = Input::get('solutions');
		foreach ($solutions as $key => $solution) {
			$warga = Warga::find($solution['id']);
			$warga->solution = $solution['solution'];			
			$warga->save();
		}

		date_default_timezone_set('Asia/Jakarta');
		Konfigurasi::where('key','=','latest_topsis_calculation')
		->update(array('value' => date('l, d F Y H:i:s')));

		return "success updating";
	}

	

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	/*public function doTopsis(){
		$warga = Warga::all();
		$kriteria = Kriteria::all();

		$calculatedWarga = Array();
		$unCalculatedWarga = Array();
		$squaredMatrix = Array();
		$sqRootAllCrit = Array();


		//separate
		foreach ($warga as $key => $war) {
			
			if(count($kriteria) == count($war->nilai)){
				array_push($calculatedWarga, $war);
			}else{
				array_push($unCalculatedWarga, $war);
			}
		}

		//start TOPSIS calculation, get squared matrix
		foreach ($calculatedWarga as $key => $war) {			
			
			foreach ($war->nilai as $idx => $nilai) {					
				$squared = $nilai->nilai * $nilai->nilai;
				$squaredMatrix[$war->no_kk][$nilai->kriteria->nama] = $squared;
			}
			
		}

		//initialize
		foreach ($kriteria as $krit) {
			$sqRootAllCrit[$krit->nama] = 0;
		}

		//sumerize all squared criteria number
		foreach ($squaredMatrix as $eachCitizenSquared) {			
			foreach ($eachCitizenSquared as $critName => $critNumber) {				
				$sqRootAllCrit[$critName] += $critNumber;
			}
		}

		//finalize, get the square root
		foreach ($sqRootAllCrit as $critName => $sumCritNumber) {
			$sqRootAllCrit[$critName] = sqrt($sumCritNumber);
		}

		//weight and normalize all data, 
		//divide it with square root sum of criteria and multiple it by weight of each criteria
		$normalizedWeightedWarga = Array();
		foreach ($calculatedWarga as $key => $war) {
			foreach ($war->nilai as $nilai) {
				$normalizedWeightedWarga[$war->no_kk][$nilai->kriteria->nama] = 
				$nilai->nilai/$sqRootAllCrit[$nilai->kriteria->nama] * $nilai->kriteria->bobot/100 ;
			}
		}

		//create matrix criteria x warga name
		$criteriaMatrix = Array();
		foreach ($normalizedWeightedWarga as $wargaName => $eachWarga) {
			foreach ($eachWarga as $criteriaName => $criteriaNumber) {
				$criteriaMatrix[$criteriaName][$wargaName] = $criteriaNumber;
			}			
		}

		//get ideal positive and negative for each criteria
		foreach ($criteriaMatrix as $critName => $critNumber) {
			$idealPositiveOfCriteria[$critName] = max($critNumber);
			$idealNegativeOfCriteria[$critName] = min($critNumber);
		}
		
		//set distance ideal positive and negative for each warga
		$distancePositiveOfWarga = Array();
		$distanceNegativeOfWarga = Array();
		foreach ($normalizedWeightedWarga as $wargaName => $eachWarga) {
			$distancePositiveOfWarga[$wargaName] = 0.5;
			$distanceNegativeOfWarga[$wargaName] = 0.5;
			foreach ($eachWarga as $critName => $critNumber) {
				$distancePositiveOfWarga[$wargaName] += pow($critNumber - $idealPositiveOfCriteria[$critName], 2);
				$distanceNegativeOfWarga[$wargaName] += pow($critNumber - $idealNegativeOfCriteria[$critName], 2);
			}
		}

		//get the square root of distance ideal positive and negative
		foreach ($normalizedWeightedWarga as $wargaName => $eachWarga) {
			$distanceNegativeOfWarga[$wargaName] = sqrt($distanceNegativeOfWarga[$wargaName]);
			$distancePositiveOfWarga[$wargaName] = sqrt($distancePositiveOfWarga[$wargaName]);

			$proxOfIdealSolution[$wargaName] = $distanceNegativeOfWarga[$wargaName]/($distancePositiveOfWarga[$wargaName]+$distanceNegativeOfWarga[$wargaName]);
			//$proxOfIdealSolution[$wargaName] = 1.00;
		}

		$finalDataWarga = Array();
		foreach ($calculatedWarga as $key => $warga) {
			$warga['solution'] = $proxOfIdealSolution[$warga->no_kk];
		}		

		usort($calculatedWarga, function($a, $b){
			return strcmp($b->solution, $a->solution);
		});		

		return $calculatedWarga;
	}*/

}
