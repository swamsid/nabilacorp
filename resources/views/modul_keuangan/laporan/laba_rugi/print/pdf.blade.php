<?php 
	$tanggal_1 = switchBulan(explode('/', $_GET['d1'])[0]).' '.explode('/', $_GET['d1'])[1];
?>

<table width="100%">
	<thead>
		<tr>
			<td style="font-weight: 800">Laporan Laba Rugi</td>
		</tr>

		<tr>
			<td>{{ jurnal()->companyName }}</td>
		</tr>

		<tr>
			<td style="border-bottom: 1px solid #ccc; padding-bottom: 20px;"><small>Bulan {{ $tanggal_1 }}</small></td>
		</tr>
	</thead>
</table>

<br>
		<table width="100%" style="font-size: 9pt;">
			<tbody>
				<tr>
					<td style="vertical-align: top;">
						<table width="100%">
							<?php $aktiva = $pasiva = 0 ?>
							@foreach($data['data'] as $key => $header)
								<?php $totHead = 0 ?>
								<tr>
									<td colspan="2" style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">{{ $header->gs_nama }}</td>
								</tr>
	 
								@foreach($header->group as $key => $group)
									<tr>
										<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">{{ $group->ag_nama }}</td>

										<?php 
											$totGR = 0;

											foreach($group->lr as $key => $akun){
												foreach($akun->fromKelompok as $key => $detail){
													$plus = $minus = 0;

													if($detail->ak_posisi == 'D'){
														$plus = ($detail->kas_debet + $detail->bank_debet + $detail->memorial_debet);

														$monius = ($detail->kas_kredit + $detail->bank_kredit + $detail->memorial_kredit);
													}else{
														$plus = ($detail->kas_kredit + $detail->bank_kredit + $detail->memorial_kredit);

														$monius = ($detail->kas_debet + $detail->bank_debet + $detail->memorial_debet);
													}

													$totGR += ($detail->ak_posisi == "D") ? (($plus - $minus) * -1) : ($plus - $minus);
												}
											}

											$totHead += $totGR;
										?>

										<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ ($totGR < 0) ? '('.number_format(str_replace('-', '', $totGR), 2).')' : number_format($totGR, 2) }}</td>
									</tr>

									@foreach($group->lr as $key => $akun)
										
										<?php 
											$nama = "";

											foreach($data['kelompok'] as $r => $kelompok){
												if($akun->ak_kelompok == $kelompok->ak_kelompok){
													$nama = $kelompok->ak_nama;
													break;
												}
											}
										?>

										<tr>
											<td style="border-bottom: 1px solid #ccc; padding-left: 40px; padding-top: 5px; padding-bottom: 5px;">{{ $nama }}</td>

											<?php 
												$tot = 0;

												foreach($akun->fromKelompok as $key => $detail){
													$plus = $minus = 0;

													if($detail->ak_posisi == 'D'){
														$plus = ($detail->kas_debet + $detail->bank_debet + $detail->memorial_debet);

														$monius = ($detail->kas_kredit + $detail->bank_kredit + $detail->memorial_kredit);
													}else{
														$plus = ($detail->kas_kredit + $detail->bank_kredit + $detail->memorial_kredit);

														$monius = ($detail->kas_debet + $detail->bank_debet + $detail->memorial_debet);
													}

													$tot += ($detail->ak_posisi == "D") ? (($plus - $minus) * -1) : ($plus - $minus);
												}
											?>

											<td style="font-weight: normal; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">
												{{ ($tot < 0) ? '('.number_format(str_replace('-', '', $tot), 2).')' : number_format($tot, 2) }}
											</td>
										</tr>

									@endforeach

								@endforeach

								<tr>
									<td style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; background-color: #eeeeee;">Total {{ $header->gs_nama }}</td>

									<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px; background-color: #eeeeee;">
										{{($totHead < 0) ? '('.number_format(str_replace('-', '', $totHead), 2).')' : number_format($totHead, 2) }}
									</td>
									
								</tr>

								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>

								<?php $aktiva += $totHead ?>
							@endforeach
						</table>
					</td>
				</tr>

				<tr>
					<td>
						<table width="100%">
							<tr>
								<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">Total Pendapatan</td>

								<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($aktiva, 2) }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>