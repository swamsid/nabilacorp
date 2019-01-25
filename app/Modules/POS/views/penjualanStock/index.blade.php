@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
			<div class="page-title">Barang Titip</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
			<li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li class="active">Barang Titip</li>
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
						<li class="active"><a id="penjualan" href="#toko" data-toggle="tab">Form Barang Titip</a></li>
                                <li><a id="list" href="#listtoko" data-toggle="tab">List Barang Titip</a></li><!-- 
                                <li><a href="#mobil" data-toggle="tab">Penjualan Mobil</a></li>
                                <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
                                <!-- <li><a href="#konsinyasi" data-toggle="tab">Penjualan Konsinyasi</a></li> -->
                            </ul>
                            <div id="generalTabContent" class="tab-content responsive">
                            
        
<div id="toko" class="tab-pane fade in active">
  
      <div class="row">
        <div class="col-lg-12">

          <table class="table table-stripped tabelan table-bordered table-hover dt-responsive data-table tableListToko" width="100%" id="dataStock">
            <thead>
              <th>No</th>
              <th>Nama Barang / satuan</th>
              <th>Gudang</th>
              <th>Stok</th>
            </thead>
            
          </table>

        </div>

       </div>
  
</div>



                            </div> <!-- End div general-content -->

                        </div>
                    </div>

                    @endsection
                    @section("extra_scripts")
                    <script type="text/javascript">

var tablex;
setTimeout(function () {
        table();

    tablex.on('draw.dt', function () {
            var info = tablex.page.info();
            tablex.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
        });
    });

      }, 1500);

function table(){
    $('#dataStock').dataTable().fnDestroy();
    tablex = $("#dataStock").DataTable({        
         
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("penjualan/stok/data") }}",
              "type": "get",              
              },
            columns: [
            {data: 'i_name', name: 'i_name'}, 
            {data: 'i_name', name: 'i_name'}, 
            {data: 'gc_gudang', name: 'gc_gudang'},
            {data: 's_qty', name: 's_qty'},            
           
            ],             
            responsive: false,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
             
           
    });
  }



                    </script>
                    @endsection