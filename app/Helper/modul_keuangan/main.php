<?php
	
	function getBulan(){
		$bulan = [
			[
				"nama"		=> 'Januari',
				"value"		=> '01'
			],

			[
				"nama"		=> 'Februari',
				"value"		=> '02'
			],

			[
				"nama"		=> 'Maret',
				"value"		=> '03'
			],

			[
				"nama"		=> 'April',
				"value"		=> '04'
			],

			[
				"nama"		=> 'Mei',
				"value"		=> '05'
			],

			[
				"nama"		=> 'Juni',
				"value"		=> '06'
			],

			[
				"nama"		=> 'Juli',
				"value"		=> '07'
			],

			[
				"nama"		=> 'Agustus',
				"value"		=> '08'
			],

			[
				"nama"		=> 'September',
				"value"		=> '09'
			],

			[
				"nama"		=> 'Oktober',
				"value"		=> '10'
			],

			[
				"nama"		=> 'November',
				"value"		=> '11'
			],

			[
				"nama"		=> 'Desember',
				"value"		=> '12'
			],
		];

		return $bulan;
	}
	
	function switchBulan($bulan){
		
		if($bulan == '01' || $bulan == '1')
			return 'Januari';
		else if($bulan == '02' || $bulan == '2')
			return 'Februari';
		else if($bulan == '03' || $bulan == '3')
			return 'Maret';
		else if($bulan == '04' || $bulan == '4')
			return 'April';
		else if($bulan == '05' || $bulan == '5')
			return 'Mei';
		else if($bulan == '06' || $bulan == '6')
			return 'Juni';
		else if($bulan == '07' || $bulan == '7')
			return 'Juli';
		else if($bulan == '08' || $bulan == '8')
			return 'Agustus';
		else if($bulan == '09' || $bulan == '9')
			return 'September';
		else if($bulan == '10')
			return 'Oktober';
		else if($bulan == '11')
			return 'November';
		else if($bulan == '12')
			return 'Desember';

		return "Bulan Tidak Diketahui";
	}

	function modulSetting(){
		$setting = [
			// Container
				'extraScripts' 		   => 'extra_scripts',
				'extraStyles'  		   => 'extra_styles',

			// modul
				'support_cabang'	   => false,
				'id_pusat'			   => 1,
				'onLogin'              => 1
		];

		return $setting;
	}

	function jurnal(){
		$setting = [
			// setting
				'allowJurnalToExecute'	=> true,
				'comp'					=> 1,
				'companyName'			=> 'Nabilla Bakery',
		];

		return (object) $setting;
	}

	function tabel(){
		$data = [
			// tabel cabang

			'cabang'	=> [
				'nama'	=> 'sup_cabang',
				'kolom'	=> [
					'id'	=> 'cab_id',
					'nama'	=> 'cab_nama'
				]
			]
		];

		
		$data = array_to_object($data);
		

		return $data;
	}

	function array_to_object($array){
		
		$obj = new stdClass;

		foreach($array as $k => $v) {
		    if(strlen($k)) {
		        if(is_array($v)) {
		           $obj->{$k} = array_to_object($v); //RECURSION
		        } else {
		           $obj->{$k} = $v;
		        }
		    }
		}

		return $obj;
	}

?>