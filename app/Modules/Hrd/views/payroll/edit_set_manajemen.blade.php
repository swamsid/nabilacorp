@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
			<div class="page-title">Setting Gaji</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
			<li>
				<i class="fa fa-home"></i>&nbsp;
				<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
				<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li>
				<i></i>&nbsp;HRD&nbsp;&nbsp;
				<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li class="active">Setting Gaji</li>
		</ol>
		<div class="clearfix">
		</div>
	</div>
	<div class="page-content fadeInRight">
		<div id="tab-general">
			<div class="row mbl">
				<div class="col-lg-12">
					<div class="col-md-12">
						<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
						</div>
					</div>
					<ul id="generalTab" class="nav nav-tabs">
						<li class="active">
							<a href="#alert-tab" data-toggle="tab">Setting Gaji</a>
						</li>
						<!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
								<li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
					</ul>
					<div id="generalTabContent" class="tab-content responsive">
						<div id="alert-tab" class="tab-pane fade in active">
							<div class="row">
								<div class="col-md-12">
									<form method="POST" id="gajiMan">
										{{ csrf_field() }}
										<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">Nama Gaji<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->nm_gaji }}" name="nm_gaji" class="form-control input-sm">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">Jumlah</label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<div class="input-group">
														<input type="text" id="jumlah" name="jumlah" class="form-control input-sm text-right rupiah">
														<span class="input-group-btn">
															<button type="button" class="btn btn-success btn-sm" onclick="samakan()">Samakan</button>
														</span>
													</div>
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">Jabatan<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<select id="" name="c_jabatan" class="form-control input-sm">
														<option <?php if($data->c_jabatan == "1"){ echo "selected"; }?> value="1">Leader</option>
														<option <?php if($data->c_jabatan == "2"){ echo "selected"; }?> value="2">Staf</option>
														<option <?php if($data->c_jabatan == "3"){ echo "selected"; }?> value="3">Semua</option>
													</select>
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">SD<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->c_sd }}" id="sd" name="c_sd" class="form-control input-sm text-right rupiah">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">SMP<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->c_smp }}" id="smp" name="c_smp" class="form-control input-sm text-right rupiah">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">SMA<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->c_sma }}" id="sma" name="c_sma" class="form-control input-sm text-right rupiah">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">SMK<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->c_smk }}" id="smk" name="c_smk" class="form-control input-sm text-right rupiah">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">D1<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->c_d1 }}" id="d1" name="c_d1" class="form-control input-sm text-right rupiah">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">D2<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->c_d2 }}" id="d2" name="c_d2" class="form-control input-sm text-right rupiah">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">D3<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->c_d3 }}" id="d3" name="c_d3" class="form-control input-sm text-right rupiah">
												</div>
											</div>
											<div class="col-md-2 col-sm-4 col-xs-12">
												<label class="tebal">S1<font color="red">*</font></label>
											</div>
											<div class="col-md-4 col-sm-8 col-xs-12">
												<div class="form-group">
													<input type="text" value="{{ $data->c_s1 }}" id="s1" name="c_s1" class="form-control input-sm text-right rupiah">
												</div>
											</div>

											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<button style="float: right" class="btn btn-primary btn-block simpanGaji" onclick="updateGajiMan({{$data->c_id}})">Update
													</button>
												</div>
											</div>



									</form>
								</div>

							</div>
						</div>
					</div>
				</div>
				@endsection @section('extra_scripts')
				<script type="text/javascript">
					$(document).ready(function () {
						var extensions = {
							"sFilterInput": "form-control input-sm",
							"sLengthSelect": "form-control input-sm"
						}
						// Used when bJQueryUI is false
						$.extend($.fn.dataTableExt.oStdClasses, extensions);
						// Used when bJQueryUI is true

						$.extend($.fn.dataTableExt.oJUIClasses, extensions);

						$('.rupiah').inputmask("currency", {
							radixPoint: ",",
							groupSeparator: ".",
							digits: 2,
							allowMinus: false,
							autoGroup: true,
							prefix: '', //Space after $, this will not truncate the first character.
							rightAlign: false,
							oncleared: function () {}
						});

					});

					function samakan() {
						var jum = $('#jumlah').val();
						console.log(jum);
						$('#sd').val(jum);
						$('#smp').val(jum);
						$('#sma').val(jum);
						$('#smk ').val(jum);
						$('#d1').val(jum);
						$('#d2').val(jum);
						$('#d3').val(jum);
						$('#s1').val(jum);
					}

					function updateGajiMan(x) {
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});
						$('.simpanGaji').attr('disabled', 'disabled');
						$.ajax({
							url: baseUrl + "/hrd/payroll/update-gaji-man/" + x,
							type: "POST",
							data: $('#gajiMan').serialize(),
							success: function (response) {
								if (response.status == 'sukses') {
									iziToast.success({
										timeout: 5000,
										position: "topRight",
										icon: 'fa fa-chrome',
										title: '',
										message: 'Data Berhasil di Update.'
									});
									window.location.href = baseUrl + "/hrd/payroll/setting-gaji";
								} else {
									iziToast.error({
										position: "topRight",
										title: '',
										message: 'Data Gagal di Update.'
									});
									$('.simpanGaji').removeAttr('disabled', 'disabled');
								}
							}
						});
					}
				</script> @endsection