<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Analisa Rasio Keuangan</title>
        
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/bootstrap_4_1_3/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/font-awesome_4_7_0/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/css/style.css') }}">
  		<link rel="stylesheet" type="text/css" href="{{asset('modul_keuangan/js/vendors/ez_popup_v_1_1/ez.popup.css')}}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/select2/dist/css/select2.min.css') }}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/datepicker/dist/datepicker.min.css') }}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">

		<style>

			body{
				background: rgba(0,0,0, 0.5);
			}

			/*.bs-datepicker-container { z-index: 3000; }*/

			.lds-dual-ring {
			  display: inline-block;
			  width: 64px;
			  height: 64px;
			}
			.lds-dual-ring:after {
			  content: " ";
			  display: block;
			  width: 46px;
			  height: 46px;
			  margin: 1px;
			  border-radius: 50%;
			  border: 5px solid #dfc;
			  border-color: #dfc transparent #dfc transparent;
			  animation: lds-dual-ring 1.2s linear infinite;
			}
			@keyframes lds-dual-ring {
			  0% {
			    transform: rotate(0deg);
			  }
			  100% {
			    transform: rotate(360deg);
			  }
			}

		    .navbar-brand {
		    	padding-left: 30px;
		    }

		    .navbar-nav {
		      flex-direction: row;
		      padding-right: 40px; 
		    }
		    
		    .nav-link {
		      padding-right: .5rem !important;
		      padding-left: .5rem !important;
		    }
		    
		    /* Fixes dropdown menus placed on the right side */
		    .ml-auto .dropdown-menu {
		      left: auto !important;
		      right: 0px;
		    }

		    .nav-item{
		    	color: white;
		    }

		    .navbar-nav li{
		        border-left: 1px solid rgba(255, 255, 255, 0.1);
		        padding: 0px 25px;
		        cursor: pointer;
		    }

		    .navbar-nav li:last-child{
		    	border-right: 1px solid rgba(255, 255, 255, 0.1);
		    }

		    .ctn-nav {
		    	background: rgba(0,0,0, 0.7);
		    	position: fixed;
		    	bottom: 1.5em;
		    	z-index: 1000;
		    	font-size: 10pt;
		    	box-shadow: 0px 0px 10px #aaa;
		    	border-radius: 10px
		    }

		    #title-table{
		    	padding: 0px;
		    }

		    #table-data{
		    	font-size: 9pt;
		    }

		    #table-data td, #table-data th {
		    	padding: 5px 10px;
		    	border: 1px solid #cfcfcf;
		    }

		    #table-data th.head{
		    	font-weight: 800;
		    	font-size: 12pt;
		    	border: 0px;
		    	padding-left: 0px;
		    	padding-bottom: 0px;
		    	text-align: left;
		    	color: #444;
		    }

		    #table-data th.subHead{
		    	font-weight: 800;
		    	font-size: 9pt;
		    	border: 0px;
		    	padding-left: 0px;
		    	padding-bottom: 0px;
		    	text-align: left;
		    	color: #444;
		    	text-decoration: underline;
		    	font-style: italic;
		    }

		    #table-data th.subHead.chartLeft{
		     	padding: 0px 0px;
		     	width: 60%;
		    }

		    #table-data th.subHead.chartRight{
		     	vertical-align: top;
		     	background: none;
		     	text-decoration: none;
		     	width: 40%;
		     }

		    #table-data td{
		    	font-size: 8pt;
		    }

		    #table-data td.head{
		    	border: 1px solid white;
		    	background: #0099CC;
		    	color: white;
		    	font-weight: bold;
		    	text-align: center;
		    }

		    #table-data td.sub-head{
		    	border: 1px solid #0099CC;
		    	color: #333;
		    	font-weight: bold;
		    	text-align: center;
		    }

		    #contentnya{
	          width: 85%;
	          padding: 0px 20px;
	          background: white;
	          min-height: 550px;
	          border-radius: 2px;
	          margin: 0 auto;
	          padding-bottom: 20px;
	        }

		</style>

		<style type="text/css" media="print">
          @page { size: portrait; }

          body{
          	margin: 0mm;
          }
          nav{
            display: none;
          }

          #contentnya{
            margin-top: -80px;
            width: 100%;
           }

          #table-data th{
             background-color: #0099CC !important;
             color: white;
             -webkit-print-color-adjust: exact;
          }

          #table-data th.subHead, #table-data th.head{
             background-color:white !important;
             -webkit-print-color-adjust: exact;
          }

          #table-data th.subHead.divide{
          	display: none;
          }

          #table-data td.not-same{
             color: red !important;
             -webkit-print-color-adjust: exact;
          }

          .page-break { display: block; page-break-before: always; }
      </style>
	</head>

	<body>
		<div id="vue-element">
			<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="box-shadow: 0px 5px 10px #555;">
			    <a class="navbar-brand" href="{{ url('/') }}">{{ jurnal()->companyName }}</a>
			</nav>

			<div class="container-fluid" id="contentnya" style="background: none; margin-top: 70px; padding: 10px 30px;">
				<div id="contentnya">				

					{{-- Judul Kop --}}

						<table width="100%" border="0" style="border-bottom: 1px solid #333;">
				          <thead>
				            <tr>
				              <th style="text-align: left; font-size: 14pt; font-weight: 600; padding-top: 10px;" colspan="2">Analisa Penjualan</th>
				            </tr>

				            <tr>
				              <th style="text-align: left; font-size: 12pt; font-weight: 500" colspan="2">{{ jurnal()->companyName }} &nbsp;</th>
				            </tr>

				            <tr>
				              <th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">(Data Dibawah Menunjukkan {{ $request->counter }} Item Terlaris Dalam Periode Terpilih)</th>

				              <th class="text-right" style="font-size: 8pt; font-weight: normal;">
				              	<b>Periode {{ $request->date1 }} s/d {{ $request->date2 }}</b>
				              </th>
				            </tr>
				          </thead>
				        </table>

				    {{-- End Judul Kop --}}

				    <table class="table" id='table-data' style="margin-top: 15px;">
				    	<thead>
				    		<tr>
								<th class="head" colspan="13">
									<!-- <i class="fa fa-chevron-right"></i> &nbsp;Rasio Likuiditas (Liquidity ratio) -->
								</th>
							</tr>
				    	</thead>
				    </table>

			    	<div style="padding-top: 0px;">

			    		<table class="table">
			    			<thead>
			    				<tr>
			    					<td width="50%" class="text-center" style="border-bottom: 1px solid #eee; border-right: 1px solid #eee;">
			    						Nama Item : <b>{{ $headNama }}</b>
			    					</td>
			    					<td class="text-center" style="border-bottom: 1px solid #eee;">
			    						Total Penjualan Di Periode Terpilih : <b>{{ $headValue }}</b>
			    					</td>
			    				</tr>
			    			</thead>
			    		</table>

			    		<!-- <table class="table" id='table-data' style="margin-top: 15px;">
					    	<thead>
					    		<tr>
									<th class="subHead">
										<i class="fa fa-caret-right" style="font-size: 9pt;"></i> &nbsp;Detail Nota Penjualan Pada Periode Terkait
									</th>
								</tr>
					    	</thead>
					    </table> -->

						<table class="table" id="table-data">
							<thead>
								<tr>
									<th width="20%">Tanggal Transaksi</th>
									<th width="60%">Nomor Nota</th>
									<th>Total Penjualan</th>
								</tr>
							</thead>
							
							<tbody>
								@foreach($data as $key => $dta)
									<tr>
										<td class="text-center">{{ date('m-d-Y', strtotime($dta->s_date)) }}</td>
										<td class="text-center">{{ $dta->s_note }}</td>
										<td class="text-center">{{ $dta->sd_qty }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>

						<table class="table" id="table-data" style="margin-top: 40px;">
							<thead>
								<tr>
									<th class="subHead">
										<i class="fa fa-caret-right" style="font-size: 9pt;"></i> &nbsp;Persentase Item Terlaris
									</th>
								</tr>

								<tr>
									<th class="subHead">
										<canvas id="canvas" height="150px;"></canvas>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>

		</div>

		<script src="{{ asset('modul_keuangan/js/jquery_3_3_1.min.js') }}"></script>
		<script src="{{ asset('modul_keuangan/bootstrap_4_1_3/js/bootstrap.min.js') }}"></script>
		<script src="{{asset('modul_keuangan/js/vendors/ez_popup_v_1_1/ez.popup.js')}}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/select2/dist/js/select2.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/datepicker/dist/datepicker.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>

    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/vue_2_x.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/select.component.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/datepicker.component.js') }}"></script>
		<script src="{{ asset('modul_keuangan/js/vendors/chart_js_2_7_3/Chart.bundle.min.js') }}"></script>
		<script src="{{ asset('modul_keuangan/js/vendors/sparkline/sparkline.min.js') }}"></script>

		<script type="text/javascript">
			var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
				var config = {
					type: 'bar',
					data: {
						labels: {!! $dataNama !!},
						datasets: [

							{
								steppedLine: false,
								label: ' Nilai Penjualan Periode Sebelum',
								backgroundColor: '#ff4444',
								borderColor: '#ff4444',
								data: {!! $dataValue !!},
								fill: false,
								showLine: true,
								pointRadius: 4,
								pointHoverRadius: 8
							},
						]
					},
					options: {
						responsive: true,
						title: {
							display: false,
							text: 'Liquidity Ratio'
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Periode'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Nilai'
								},
								ticks: {
									suggestedMin: 0,
									suggestedMax: 15,
								}
							}]
						},
						elements: {
							point: {
								pointStyle: 'rectRounded'
							}
						},
						legend: {
							display: true
						},
					}
				};

				Chart.plugins.register({
					afterDatasetsDraw: function(chart) {
						var ctx = chart.ctx;

						chart.data.datasets.forEach(function(dataset, i) {
							var meta = chart.getDatasetMeta(i);
							if (!meta.hidden) {
								meta.data.forEach(function(element, index) {
									// Draw the text in black, with the specified font
									ctx.fillStyle = '#2E2E2E';

									var fontSize = 11;
									var fontStyle = 'normal';
									var fontFamily = 'Helvetica Neue';
									ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

									// Just naively convert to string for now
									var dataString = dataset.data[index].toString();

									// Make sure alignment settings are correct
									ctx.textAlign = 'center';
									ctx.textBaseline = 'middle';

									var padding = 5;
									var position = element.tooltipPosition();
									ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
								});
							}
						});
					}
				});

				window.onload = function() {
					var ctx = document.getElementById('canvas').getContext('2d');
					window.myLine = new Chart(ctx, config);
					$("#pie-chart-1").sparkline([1,2], {
					    type: 'pie',
					    width: '100',
					    height: '100',
					    sliceColors: ['#4285F4', '#ff4444'],
					});
				};
		</script>
	</body>
</html>
