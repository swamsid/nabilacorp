@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">POS Penjualan Toko</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;<a href="{{url('penjualan/POSpenjualan/POSpenjualan')}}">POS Penjualan Toko / Mobile</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">POS Penjualan Toko</li>
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
                                <li class="active"><a href="#toko" data-toggle="tab">Penjualan Toko</a></li>
                                <li><a href="#listtoko" data-toggle="tab">List Penjualan Toko</a></li><!-- 
                                <li><a href="#mobil" data-toggle="tab">Penjualan Mobil</a></li>
                                <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
                                <!-- <li><a href="#konsinyasi" data-toggle="tab">Penjualan Konsinyasi</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                <!-- Modal -->
                                @include('penjualan.POSpenjualanToko.modal')
                                <!-- End Modal -->
                                
                                <!-- div #alert-tab -->
                                @include('penjualan.POSpenjualanToko.toko')
                                <!-- /div #alert-tab -->

                                <!-- Div #listtoko -->
                                @include('penjualan.POSpenjualanToko.listtoko')
                                <!-- end div #listoko -->
                           

                            </div> <!-- End div general-content -->
                    
            </div>
          </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">

      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
      });
      $('.datepicker2').datepicker({
        format:"dd-mm-yyyy"
      });    

      $(document).ready(function() {
        var table           = $("#t10m").DataTable();
        var qty             = $("#q_qty");
        var n_item          = $("#n_item");

        var counter = 1;
 
    qty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
        table.row.add( [
            '<input type="text" id="item_kode[]" class="form-control input-sm">',
            '<input type="text" id="item_name[]" class="form-control input-sm" value="'+ n_item.val() +'">',
            '<input type="number" id="jumlah[]" class="form-control input-sm" value="'+ qty.val() +'">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<button type="button" class="delete btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>',
        ] ).draw( false );
  
        counter++;
        n_item.focus();
        n_item.val('');
        qty.val('');
      }
    } );
 
    

    $('#t10m tbody').on( 'click', '.delete', function () {
    table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    });

});
      </script>
@endsection