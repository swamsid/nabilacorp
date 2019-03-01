@extends('main')

@section('title', 'Master Akun')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    
@endsection


@section('content')
    <div class="col-md-12" style="background: none;">
    	<div class="col-md-12">
    		<div class="row">
    			<div class="col-md-6 content-title">
    				Master Data Akun Cabang &nbsp;
                    <i class="fa fa-info-circle" title="Akun Cabang Adalah Akun-Akun Yang Nantinya Akan Digunakan Oleh Cabang-Cabang Perusahaan."></i>
    			</div>

    			<div class="col-md-6 text-right">
                    <a href="{{ route('akun.cabang.create') }}">
    				    <button class="btn btn-info btn-sm">Tambah / Edit Data Akun Cabang</button>
                    </a>
    			</div>
    		</div>	
    	</div>

    	<div class="col-md-12 table-content">
    		<table class="table table-bordered table-stripped" id="data-sample">
    			<thead>
    				<tr>
    					<th width="5%">No</th>
    					<th width="12%">Nomor Akun</th>
    					<th width="30%">Nama Akun</th>
                        <th width="20%">Kelompok</th>
                        <th width="8%">D/K</th>
                        <th width="15%">Tanggal Buat</th>
    					<th width="10">Aksi</th>
    				</tr>
    			</thead>

    			<tbody>

                    @foreach($data as $key => $akun)
                        <?php 
                            $bg     = '#eee';
                            $color  = '#aaa';

                            if($akun->ac_isactive == '1'){
                                $bg     = 'none';
                                $color  = 'none';
                            }
                        ?>

                        <tr style="background: {{ $bg  }}; color: {{  $color }};">
                            <td class="text-center">{{ ($key+1) }}</td>
                            <td class="text-center">{{ $akun->ac_nomor }}</td>
                            <td>{{ $akun->ac_nama }}</td>
                            <td>{{ $akun->kelompok }}</td>

                            <?php 
                                if($akun->ac_posisi == 'D')
                                    $posisi = 'DEBET';
                                else
                                    $posisi = 'KREDIT';
                            ?>

                            <td class="text-center">{{ $posisi }}</td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($akun->created_at)) }}</td>
                            <td class="text-center">
                                {{-- <button class="btn btn-secondary btn-sm" title="Edit Data Group">
                                    <i class="fa fa-edit"></i>
                                </button> --}}

                                @if($akun->ac_status == 'locked')
                                    <button class="btn btn-default btn-sm" title="Akun Sedang Dikunci" style="cursor: no-drop;">
                                        <i class="fa fa-lock"></i>
                                    </button>
                                @elseif($akun->ac_isactive == '1')
                                    <button class="btn btn-success btn-sm aktifkanData" title="Nonaktifkan" data-id="{{ $akun->ac_id }}">
                                        <i class="fa fa-check-square-o"></i>
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-sm aktifkanData" title="Aktifkan" data-id="{{ $akun->ac_id }}">
                                        <i class="fa fa-square-o"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
    				
    			</tbody>
    		</table>
    	</div>
    </div>
@endsection


@section(modulSetting()['extraScripts'])
	
	<script src="{{ asset('modul_keuangan/js/options.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>
	<script src="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>

	<script type="text/javascript">

		$(document).ready(function() {
		    $('#data-sample').DataTable({
		    	"language": {
		            "lengthMenu": "Tampilkan _MENU_ Data Per Halaman",
		            "zeroRecords": "Tidak Bisa Menemukan Apapun . :(",
		            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
		            "infoEmpty": "Tidak Ada Data Apapun",
		            "infoFiltered": "(Difilter Dari _MAX_ total records)",
		            "oPaginate": {
				        "sFirst":    "Pertama",
				        "sPrevious": "Sebelumnya",
				        "sNext":     "Selanjutnya",
				        "sLast":     "Terakhir"
				    }
		        }
		    });

            $('.aktifkanData').click(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                var context = $(this);
                var cfrm = confirm('Apakah Anda Yakin ?');

                if(cfrm){
                    $('.aktifkanData').attr('disabled', 'disabled');

                    axios.post('{{ route('akun.cabang.delete') }}', { ak_id: context.data('id'), _token: '{{ csrf_token() }}' })
                            .then((response) => {
                                console.log(response.data);
                                
                                if(response.data.status == 'berhasil'){
                                    $.toast({
                                        text: response.data.message,
                                        showHideTransition: 'slide',
                                        position: 'top-right',
                                        icon: 'success',
                                        hideAfter: 5000
                                    });

                                    if(response.data.active == '0'){
                                        context.removeClass('btn-success');
                                        context.addClass('btn-danger');
                                        context.html('<i class="fa fa-square-o"></i>');
                                        context.closest('tr').css({
                                            'background': '#eee',
                                            'color'     : '#aaa'
                                        });
                                        context.attr('title', 'Aktifkan');
                                    }else{
                                        context.removeClass('btn-danger');
                                        context.addClass('btn-success');
                                        context.html('<i class="fa fa-check-square-o"></i>');
                                        context.closest('tr').css({
                                            'background': 'none',
                                            'color'     : '#6f6f6f'
                                        });
                                        context.attr('title', 'Nonaktifkan');
                                    }

                                }else{
                                    $.toast({
                                        text: response.data.message,
                                        showHideTransition: 'slide',
                                        position: 'top-right',
                                        icon: 'error',
                                        hideAfter: false
                                    });
                                }

                            })
                            .catch((err) => {
                                alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                            })
                            .then(() => {
                                $('.aktifkanData').removeAttr('disabled');
                            })
                }
            })
		});

    </script>

@endsection