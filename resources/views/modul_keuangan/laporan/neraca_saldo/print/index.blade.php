<style type="text/css" media="print">
  @page { size: landscape; }
  nav{
    display: none;
  }

  .ctn-nav{
    display: none;
  }

  #contentnya{
  	width: 100%;
  	padding: 0px;
  	margin-top: -80px;
  }

  #table-data td{
  	border: 1px solid #eee;
  }

  #table-data td.head{
     background-color: #0099CC !important;
     color: white;
     font-weight: bold;
     -webkit-print-color-adjust: exact;
  }

  #table-data td.not-same{
     color: red !important;
     -webkit-print-color-adjust: exact;
  }

  .page-break { display: block; page-break-before: always; }
</style>

<?php 
	$tanggal_1 = switchBulan(explode('/', $_GET['d1'])[0]).' '.explode('/', $_GET['d1'])[1];
?>

<table width="100%">
	<thead>
		<tr>
			<td style="font-weight: 800">Laporan Neraca Saldo</td>
		</tr>

		<tr>
			<td>{{ jurnal()->companyName }} &nbsp;- {{ $data['cabang'] }} </td>
		</tr>

		<tr>
			<td style="border-bottom: 1px solid #ccc; padding-bottom: 20px;"><small>Bulan {{ $tanggal_1 }}</small></td>
		</tr>
	</thead>
</table>

<br>

	<table id="table-data" width="100%" style="font-size: 9pt; border-collapse: collapse;">
		<tbody>
			<tr>
				<td class="head" width="8%" rowspan="2" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Kode Akun</td>
				<td class="head" width="10%" rowspan="2" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Saldo Awal</td>

				<td class="head" colspan="2" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Mutasi Kas</td>
				<td class="head" colspan="2" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Mutasi Bank</td>
				<td class="head" colspan="2" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Mutasi Memorial</td>
				<td class="head" colspan="2" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Total Mutasi</td>
				<td class="head" width="10%" rowspan="2" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Saldo Akhir</td>
			</tr>

			<tr>
				<td class="head" width="8%" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Debet</td>
				<td class="head" width="8%" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Kredit</td>

				<td class="head" width="8%" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Debet</td>
				<td class="head" width="8%" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Kredit</td>

				<td class="head" width="8%" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Debet</td>
				<td class="head" width="8%" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Kredit</td>

				<td class="head" width="8%" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Debet</td>
				<td class="head" width="8%" style="background-color: #0099cc; color: #ffffff; text-align: center; padding: 5px;">Kredit</td>
			</tr>

				<?php
					$kd = $kk = $bd = $bk = $md = $mk = $td = $tk = 0;
				?>

			@foreach($data['data'] as $key => $akun)
				<tr>
					<td style="text-align: center; padding: 5px;">{{ $akun->ak_nomor }}</td>
					<td style="text-align: right; padding: 5px;">
						{{ ($akun->saldo_awal < 0 ) ? '('.number_format(str_replace('-', '', $akun->saldo_awal), 2).')' : number_format($akun->saldo_awal, 2) }}
					</td>

					<td style="text-align: right; padding: 5px;"> {{ number_format($akun->kas_debet, 2) }}</td>
					<td style="text-align: right; padding: 5px;"> {{ number_format($akun->kas_kredit, 2) }}</td>

					<td style="text-align: right; padding: 5px;"> {{ number_format($akun->bank_debet, 2) }}</td>
					<td style="text-align: right; padding: 5px;"> {{ number_format($akun->bank_kredit, 2) }}</td>

					<td style="text-align: right; padding: 5px;"> {{ number_format($akun->memorial_debet, 2) }}</td>
					<td style="text-align: right; padding: 5px;"> {{ number_format($akun->memorial_kredit, 2) }}</td>


					<td style="text-align: right; padding: 5px;">
						{{ number_format(($akun->kas_debet + $akun->bank_debet + $akun->memorial_debet), 2) }}
					</td>
					<td style="text-align: right; padding: 5px;">
						{{ number_format(($akun->kas_kredit + $akun->bank_kredit + $akun->memorial_kredit), 2) }}
					</td>

					<td style="text-align: right; padding: 5px;">
						{{ ($akun->saldo_akhir < 0 ) ? '('.number_format(str_replace('-', '', $akun->saldo_akhir), 2).')' : number_format($akun->saldo_akhir, 2) }}
					</td>
				</tr>

				<?php
					$kd += $akun->kas_debet;
					$kk += $akun->kas_kredit;

					$bd += $akun->bank_debet;
					$bk += $akun->bank_kredit;

					$md += $akun->memorial_debet;
					$mk += $akun->memorial_kredit;

					$td += ($akun->kas_debet + $akun->bank_debet + $akun->memorial_debet);
					$tk += ($akun->kas_kredit + $akun->bank_kredit + $akun->memorial_kredit);
				?>

			@endforeach

			<tr>
				<td class="head" style="text-align: center;"></td>
				<td class="head" style="text-align: right;">
					
				</td>

				<td class="head" style="text-align: right; background-color: #0099cc; color: #ffffff; padding: 5px;"> {{ number_format($kd, 2) }}</td>
				<td class="head" style="text-align: right; background-color: #0099cc; color: #ffffff; padding: 5px;"> {{ number_format($kk, 2) }}</td>

				<td class="head" style="text-align: right; background-color: #0099cc; color: #ffffff; padding: 5px;"> {{ number_format($bd, 2) }}</td>
				<td class="head" style="text-align: right; background-color: #0099cc; color: #ffffff; padding: 5px;"> {{ number_format($bk, 2) }}</td>

				<td class="head" style="text-align: right; background-color: #0099cc; color: #ffffff; padding: 5px;"> {{ number_format($md, 2) }}</td>
				<td class="head" style="text-align: right; background-color: #0099cc; color: #ffffff; padding: 5px;"> {{ number_format($mk, 2) }}</td>


				<td class="head" style="text-align: right; background-color: #0099cc; color: #ffffff; padding: 5px;">
					{{ number_format($td, 2) }}
				</td>
				<td class="head" style="text-align: right; background-color: #0099cc; color: #ffffff; padding: 5px;">
					{{ number_format($tk, 2) }}
				</td>

				<td class="head" style="text-align: right;">
					
				</td>
			</tr>
			
		</tbody>
	</table>

<script type="text/javascript">
	// window.print()
</script>