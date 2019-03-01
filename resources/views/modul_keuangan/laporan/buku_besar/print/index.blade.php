<style type="text/css" media="print">
	@page { size: landscape; }

	body{
	  	margin: 5mm;
	}

	nav{
		display: none;
	}

	.ctn-nav{
		display: none;
	}

	#contentnya{
		width: 100%;
		padding: 0px;
		margin-top: -50px;
	}

	#table-data td.head{
	 background-color: #0099CC !important;
	 color: white;
	 -webkit-print-color-adjust: exact;
	}

	#table-data td.divide{
	 background-color: #eee !important;
	 -webkit-print-color-adjust: exact;
	}

	.page-break { display: block; page-break-before: always; }
</style>

<?php 
	$tanggal_1 = switchBulan(explode('/', $_GET['d1'])[0]).' '.explode('/', $_GET['d1'])[1];

	$tanggal_2 = switchBulan(explode('/', $_GET['d2'])[0]).' '.explode('/', $_GET['d2'])[1];

	$type = "Semua Akun";

	if(!isset($_GET['semua']))
		$type = $_GET['akun1']." s/d ".$_GET['akun2'];
?>

<table width="100%">
	<thead>
		<tr>
			<td style="font-weight: 800">Laporan Buku Besar <small>({{ $type }})</small></td>
		</tr>

		<tr>
			<td>{{ jurnal()->companyName }} &nbsp;- {{ $namaCabang }}</td>
		</tr>

		<tr>
			<td style="border-bottom: 1px solid #ccc; padding-bottom: 20px;"><small>{{ $tanggal_1 }}&nbsp; s/d&nbsp; {{ $tanggal_2 }}</small></td>
		</tr>
	</thead>
</table>

<br>

@foreach($data["data"] as $key => $akun)
	
	<?php 
		$margin =  ($key > 0) ? 'margin-top: 40px;' : '';
	?>

	<table id="table-data" width="100%" style="font-size: 9.5pt; {{ $margin  }}; border-collapse: collapse;">
		<tbody>
			<tr>
				<td class="head" colspan="8" style="background-color: #0099CC; color: white; padding: 10px;"> {{ $akun->ak_nomor.' - '.$akun->ak_nama }} </td>
			</tr>

			<tr>
				<td width="8%" style="text-align: center; border: 1px solid #0099CC; padding: 5px;"> Tanggal </td>
				<td width="13%" style="text-align: center; border: 1px solid #0099CC; padding: 5px;"> No.Bukti </td>
				<td width="31%" style="text-align: center; border: 1px solid #0099CC; padding: 5px;"> Keterangan </td>
				<td width="5%" style="text-align: center; border: 1px solid #0099CC; padding: 5px;"> DK </td>
				<td width="7%" style="text-align: center; border: 1px solid #0099CC; padding: 5px;"> Kode Akun </td>
				<td width="12%" style="text-align: center; border: 1px solid #0099CC; padding: 5px;"> Debet </td>
				<td width="12%" style="text-align: center; border: 1px solid #0099CC; padding: 5px;"> Kredit </td>
				<td width="12%" style="text-align: center; border: 1px solid #0099CC; padding: 5px;"> Saldo </td>
			</tr>

			<?php 
				$dk = "";

				if($akun->ak_saldo_awal < 0){
					if($akun->ak_posisi == "D")
						$dk = "K";
					else
						$dk = "D";
				}else{
					$dk = $akun->ak_posisi;
				}

				$saldo = $akun->ak_saldo_awal;
			?>

			<tr>
				<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;"> - </td>
				<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;"> - </td>
				<td style="padding: 2px 5px;"> Saldo Awal {{ $tanggal_1 }} </td>
				<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;"> {{ $dk }} </td>
				<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;"> {{ $akun->ak_nomor }} </td>
				<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;"> {{ ($dk == "D") ? number_format($akun->ak_saldo_awal, 2) : number_format(0, 2) }} </td>
				<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;"> {{ ($dk == "K") ? number_format($akun->ak_saldo_awal, 2) : number_format(0, 2) }} </td>
				<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;"> 
					{{ ($akun->ak_saldo_awal < 0) ? '('.number_format(str_replace('-', '', $akun->ak_saldo_awal), 2).')' : number_format($akun->ak_saldo_awal, 2) }}
				</td>
			</tr>

			<tr>
				<td class="divide" colspan="8" style="background-color: #eee;">&nbsp;</td>
			</tr>

			@foreach($akun->jurnal_detail as $key2 => $transaksi)

				<?php 
					if($transaksi->jrdt_dk != $akun->ak_posisi)
						$saldo -= $transaksi->jrdt_value;
					else
						$saldo += $transaksi->jrdt_value;
				?>

				<tr style="font-weight: 600">
					<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;">{{ date('m/d/Y', strtotime($transaksi->jurnal->jr_tanggal_trans)) }}</td>
					<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;">{{ $transaksi->jurnal->jr_ref }}</td>
					<td style="text-align: left; padding: 2px 5px; border: 1px solid #eee;">{{ $transaksi->jurnal->jr_keterangan }}</td>
					<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;">{{ $transaksi->jrdt_dk }}</td>
					<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;">{{ $akun->ak_nomor }}</td>
					<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;">
						{{ ($transaksi->jrdt_dk == 'D') ? number_format($transaksi->jrdt_value, 2) : number_format(0, 2) }}
					</td>
					<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;">
						{{ ($transaksi->jrdt_dk == 'K') ? number_format($transaksi->jrdt_value, 2) : number_format(0, 2) }}
					</td>
					<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;">
						{{ ($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo, 2) }}
					</td>
				</tr>

				@if($_GET['lawan'] == 'true')
					@foreach($transaksi->jurnal->detail as $key3 => $lawan)
						@if($lawan->ak_nomor != $akun->ak_nomor)
							<tr style="font-weight: normal">
								<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;">{{ date('m/d/Y', strtotime($transaksi->jurnal->jr_tanggal_trans)) }}</td>
								<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;">{{ $transaksi->jurnal->jr_ref }}</td>
								<td style="text-align: left; padding: 2px 5px; border: 1px solid #eee;">{{ $transaksi->jurnal->jr_keterangan }}</td>
								<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;">{{ $lawan->jrdt_dk }}</td>
								<td style="text-align: center; padding: 2px 5px; border: 1px solid #eee;">{{ $lawan->ak_nomor }}</td>
								<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;">
									{{ ($lawan->jrdt_dk == 'D') ? number_format($lawan->jrdt_value, 2) : number_format(0, 2) }}
								</td>
								<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;">
									{{ ($lawan->jrdt_dk == 'K') ? number_format($lawan->jrdt_value, 2) : number_format(0, 2) }}
								</td>
								<td style="text-align: right; padding: 2px 5px; border: 1px solid #eee;">
									
								</td>
							</tr>
						@endif
					@endforeach

					<tr>
						<td class="divide" colspan="8" style="background-color: #eee;">&nbsp;</td>
					</tr>
				@endif
			@endforeach

		</tbody>
	</table>


@endforeach

<script type="text/javascript">
	window.print()
</script>