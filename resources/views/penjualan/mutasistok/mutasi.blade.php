@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Mutasi Stok</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Mutasi Stok</li>
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
                                <li class="active"><a href="#gudangtogudang" data-toggle="tab">Gudang ke Gudang</a></li>
                                <li><a href="#item-bundle" data-toggle="tab">Item ke Bundle atau Sebaliknya</a></li>
                                <li><a href="#paket" data-toggle="tab">Paket Bundle</a></li>
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                <!-- modal -->
                                @include('penjualan/mutasistok/tambah_mutasi')

                                @include('penjualan.mutasistok.detail')

                                @include('penjualan.mutasistok.tambah_bundle')

                                @include('penjualan.mutasistok.tambah_paket')

                                @include('penjualan.mutasistok.detail_paket')
                                <!-- end modal -->

                                <!-- div gudangtogudang -->
                                @include('penjualan.mutasistok.gudangtogudang')
                                <!-- /div gudangtogudang -->

                                <!-- div item-bundle -->
                                @include('penjualan.mutasistok.itembundle')
                                <!--/div item-bundle -->

                                <!-- div  paket-->
                                @include('penjualan.mutasistok.paket')
                                <!-- end div paket -->
                            </div>
                    
            </div>
          </div>

        </div>
      </div>
    </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">
    
      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd-mm-yyyy"
      });    

       $(document).ready(function() {
        var m_table           = $("#t90").DataTable();
        var m_qty             = $("#m_qty");
        var m_item          = $("#m_item");

        var x = 1;
 
    m_qty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
        m_table.row.add( [
            '<input type="text" id="item_name[]" class="form-control input-sm" value="'+ m_item.val() +'">',
            '<input type="number" id="jumlah[]" class="form-control input-sm" value="'+ m_qty.val() +'">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<button type="button" class="delete btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>',
        ] ).draw( false );
  
        x++;
        m_item.focus();
        m_item.val('');
        m_qty.val('');
      }
    } );
 
    

    $('#t90 tbody').on( 'click', '.delete', function () {
    m_table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    });

    var p_table           = $("#t64b").DataTable();
        var p_qty             = $("#p_qty");
        var p_item          = $("#p_item");

        var y = 1;
 
    p_qty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
        p_table.row.add( [
            '<input type="text" id="item_name[]" class="form-control input-sm" value="'+ p_item.val() +'">',
            '<input type="number" id="jumlah[]" class="form-control input-sm" value="'+ p_qty.val() +'">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<input type="text" id="[]" class="form-control input-sm">',
            '<button type="button" class="delete btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>',
        ] ).draw( false );
  
        y++;
        p_item.focus();
        p_item.val('');
        p_qty.val('');
      }
    } );
 
    

    $('#t64b tbody').on( 'click', '.delete', function () {
    p_table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    });
});
      </script>
@endsection()