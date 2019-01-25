<?php 
	$tanggal_1 = switchBulan(explode('/', $_GET['d1'])[0]).' '.explode('/', $_GET['d1'])[1];
?>

<table width="100%">
	<thead>
		<tr>
			<td style="font-weight: 800">Laporan Neraca</td>
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
	
	@if($_GET['tampilan'] == 'tabular')
		<table width="100%" style="font-size: 9pt;">
			<tbody>
				<tr>
					<td width="50%" style="padding: 5px; text-align: center; border: 1px solid #ccc;">Aktiva</td>
					<td width="50%" style="padding: 5px; text-align: center; border: 1px solid #ccc;">Pasiva</td>
				</tr>

				<tr>
					<td style="vertical-align: top;">
						<table width="100%">
							<?php $aktiva = $pasiva = 0 ?>
							@foreach($data['data'] as $key => $header)
								@if($header->gs_kelompok == 'aktiva')
									<?php $totHead = 0 ?>
									<tr>
										<td colspan="2" style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">{{ $header->gs_nama }}</td>
									</tr>
		 
									@foreach($header->group as $key => $group)
										<tr>
											<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">{{ $group->ag_nama }}</td>

											<?php 
												$totGR = 0;

												foreach($group->akun as $key => $akun){
													foreach($akun->fromKelompok as $key => $detail){
														$totGR += $detail->saldo_akhir;
													}
												}

												$totHead += $totGR;
											?>

											<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($totGR, 2) }}</td>
										</tr>

										@foreach($group->akun as $key => $akun)
											
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
														$tot += $detail->saldo_akhir;
													}
												?>

												<td style="font-weight: normal; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($tot, 2) }}</td>
												</tr>

										@endforeach

									@endforeach

									<tr>
										<td style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; background-color: #eeeeee;">Total {{ $header->gs_nama }}</td>

										<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px; background-color: #eeeeee;">{{ number_format($totHead, 2) }}</td>
												</tr>
									</tr>

									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>

									<?php $aktiva += $totHead ?>
								@endif
							@endforeach
						</table>
					</td>

					<td style="vertical-align: top;">
						<table width="100%">
							@foreach($data['data'] as $key => $header)
								@if($header->gs_kelompok == 'pasiva')
									<?php $totHead = 0 ?>
									<tr>
										<td colspan="2" style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">{{ $header->gs_nama }}</td>
									</tr>
		 
									@foreach($header->group as $key => $group)
										<tr>
											<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">{{ $group->ag_nama }}</td>

											<?php 
												$totGR = 0;

												foreach($group->akun as $key => $akun){
													foreach($akun->fromKelompok as $key => $detail){
														$totGR += $detail->saldo_akhir;
													}
												}

												$totHead += $totGR;
											?>

											<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($totGR, 2) }}</td>
										</tr>

										@foreach($group->akun as $key => $akun)
											
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
														$tot += $detail->saldo_akhir;
													}
												?>

												<td style="font-weight: normal; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($tot, 2) }}</td>
												</tr>

										@endforeach

									@endforeach

									<tr>
										<td style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; background-color: #eeeeee;">Total {{ $header->gs_nama }}</td>

										<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px; background-color: #eeeeee;">{{ number_format($totHead, 2) }}</td>
												</tr>
									</tr>

									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>

									<?php $pasiva += $totHead ?>
								@endif
							@endforeach
						</table>
					</td>
				</tr>

				<tr>
					<td>
						<table width="100%">
							<tr>
								<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">Total Aktiva</td>

								<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($aktiva, 2) }}</td>
							</tr>
						</table>
					</td>

					<td>
						<table width="100%">
							<tr>
								<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">Total Aktiva</td>

								<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($pasiva, 2) }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	@endif

	@if($_GET['tampilan'] == 'menurun')
		<table width="100%" style="font-size: 9pt;">
			<tbody>
				<tr>
					<td style="padding: 5px; text-align: center; border-bottom: 1px solid #ccc;">Aktiva</td>
				</tr>

				<tr>
					<td style="vertical-align: top;">
						<table width="100%">
							<?php $aktiva = $pasiva = 0 ?>
							@foreach($data['data'] as $key => $header)
								@if($header->gs_kelompok == 'aktiva')
									<?php $totHead = 0 ?>
									<tr>
										<td colspan="2" style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">{{ $header->gs_nama }}</td>
									</tr>
		 
									@foreach($header->group as $key => $group)
										<tr>
											<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">{{ $group->ag_nama }}</td>

											<?php 
												$totGR = 0;

												foreach($group->akun as $key => $akun){
													foreach($akun->fromKelompok as $key => $detail){
														$totGR += $detail->saldo_akhir;
													}
												}

												$totHead += $totGR;
											?>

											<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($totGR, 2) }}</td>
										</tr>

										@foreach($group->akun as $key => $akun)
											
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
														$tot += $detail->saldo_akhir;
													}
												?>

												<td style="font-weight: normal; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($tot, 2) }}</td>
												</tr>

										@endforeach

									@endforeach

									<tr>
										<td style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; background-color: #eeeeee;">Total {{ $header->gs_nama }}</td>

										<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px; background-color: #eeeeee;">{{ number_format($totHead, 2) }}</td>
												</tr>
									</tr>

									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>

									<?php $aktiva += $totHead ?>
								@endif
							@endforeach
						</table>
					</td>
				</tr>

				<tr>
					<td>
						<table width="100%">
							<tr>
								<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">Total Aktiva</td>

								<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($aktiva, 2) }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>

		<table width="100%" style="font-size: 9pt; margin-top: 20px;">
			<tbody>
				<tr>
					<td style="padding: 5px; text-align: center; border-bottom: 1px solid #ccc;">Pasiva</td>
				</tr>

				<tr>
					<td style="vertical-align: top;">
						<table width="100%">
							<?php $aktiva = $pasiva = 0 ?>
							@foreach($data['data'] as $key => $header)
								@if($header->gs_kelompok == 'pasiva')
									<?php $totHead = 0 ?>
									<tr>
										<td colspan="2" style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px;">{{ $header->gs_nama }}</td>
									</tr>
		 
									@foreach($header->group as $key => $group)
										<tr>
											<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">{{ $group->ag_nama }}</td>

											<?php 
												$totGR = 0;

												foreach($group->akun as $key => $akun){
													foreach($akun->fromKelompok as $key => $detail){
														$totGR += $detail->saldo_akhir;
													}
												}

												$totHead += $totGR;
											?>

											<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($totGR, 2) }}</td>
										</tr>

										@foreach($group->akun as $key => $akun)
											
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
														$tot += $detail->saldo_akhir;
													}
												?>

												<td style="font-weight: normal; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($tot, 2) }}</td>
												</tr>

										@endforeach

									@endforeach

									<tr>
										<td style="border-bottom: 1px solid #ccc; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; background-color: #eeeeee;">Total {{ $header->gs_nama }}</td>

										<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px; background-color: #eeeeee;">{{ number_format($totHead, 2) }}</td>
												</tr>
									</tr>

									<tr>
										<td colspan="2">&nbsp;</td>
									</tr>

									<?php $aktiva += $totHead ?>
								@endif
							@endforeach
						</table>
					</td>
				</tr>

				<tr>
					<td>
						<table width="100%">
							<tr>
								<td style="border-bottom: 1px solid #ccc; padding-left: 20px; padding-top: 5px; padding-bottom: 5px;">Total Pasiva</td>

								<td style="font-weight: 800; border-bottom: 1px solid #cccccc; text-align: right; padding: 5px;">{{ number_format($pasiva, 2) }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	@endif