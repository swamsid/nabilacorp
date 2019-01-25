@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Rencana Bahan Baku Produksi</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Rencana Bahan Baku Produksi</li>
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
                                <li class="active"><a href="#alert-tab" data-toggle="tab">Rencana Bahan Baku Produksi</a></li>
                               <!--  <li><a href="#note-tab" data-toggle="tab">Retail to Grosir</a></li> -->
                                <!-- <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                
                                <div id="alert-tab" class="tab-pane fade in active">
                                 
                                  <div class="row">
                                   
                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                          
                                        <div class="table-responsive">
                                        <button onclick="tam()">tambah</button>
                                        <input type="text" class="move up" name="coba">
                                        <input type="text" class="move " name="coba">
                                        <input type="text" class="move " name="coba">
                                        <input type="text" class="move " name="coba">


<input id="foobar" />

                                        <table>
                                            <thead>
                                              <th>1</th>
                                              <th>2</th>
                                              <th>3</th>
                                              <th>3</th>
                                            </thead>
                                            <tbody class="coba">
                                            <tr>
                                              <td><input type="text" class="move up" name="coba"></td>
                                              <td><input type="text" class="move upd" name="coba"></td>
                                              <td><input type="text" class="move " name="coba"></td>
                                              <td><input type="text" class="move " name="coba"></td>
                                            </tr>
                                            <tr>
                                              <td><input type="text" class="move up" name="coba"></td>
                                              <td><input type="text" class="move upd" name="coba"></td>
                                              <td><input type="text" class="move" name="coba"></td>
                                              <td><input type="text" class="move" name="coba"></td>
                                            </tr>
                                            <tr>
                                              <td><input type="text" class="move up" name="coba"></td>
                                              <td><input type="text" class="move upd" name="coba"></td>
                                              <td><input type="text" class="move " name="coba"></td>
                                              <td><input type="text" class="move " name="coba"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button onclick="tam()" class="move">tambah</button>

                                        <br>
                                          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                                            <thead>
                                              <tr>
                                                <th>Kode Bahan Baku</th>
                                               <th>Nama Bahan Baku</th>
                                               <th>Kebutuhan</th>
                                               <th>Stok</th>
                                               <th>Kekurangan</th>
                                              </tr>
                                            </thead>

                                            <tbody>
                                              <tr>
                                                <td>111</td>
                                                <td>Tepung</td>
                                                <td>40</td>
                                                <td>30</td>
                                                <td>-10</td>
                                              </tr>
                                              <tr>
                                                <td>112</td>
                                                <td>Telur</td>
                                                <td>30</td>
                                                <td>25</td>
                                                <td>-5</td>
                                              </tr>
                                              <tr>
                                                <td>113</td>
                                                <td>Garam</td>
                                                <td>23</td>
                                                <td>24</td>
                                                <td>-1</td>
                                              </tr>
                                            </tbody>
                                          </table> 
                                        </div> 

                                      </div>
                                  </div>


                                  
                                </div>
                                <!-- /div alert-tab -->
                                <!-- div note-tab -->
                                <div id="note-tab" class="tab-pane fade">
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                          <!-- Isi Content  -->

                                    </div>
                                  </div>
                                </div><!--/div note-tab -->
                                <!-- div label-badge-tab -->
                                <div id="label-badge-tab" class="tab-pane fade">
                                  <div class="row">
                                    <div class="panel-body">
                                      <!-- Isi content -->we
                                    </div>
                                  </div>
                                </div>
                                <!-- /div label-badge-tab -->
                            </div>
                    
            </div>
          </div>

        </div>
      </div>
    </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">
     $(document).ready(function() {
    var extensions = {
         "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    $('#data').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
    $('#data2').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
    $('#data3').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
});
      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd/mm/yyyy"
      });    
      function tam(){
          $html='<tr>'+
              '<td><input type="text" class="move up" name="coba"></td>'+
              '<td><input type="text" name="coba" class="move"></td>'+
              '<td><input type="text" name="coba" class="move"></td>'+
              '<td><input type="text" name="coba" class="move"></td>'+
              '</tr>';
          $('.coba').append($html);

                 $('.move').keydown(function (e) {
                     if (e.which === 39) {
                         var index = $('.move').index(this) + 1;
                         $('.move').eq(index).focus();
                      }
                      if (e.which === 37) {
                         var index = $('.move').index(this) - 1;
                         $('.move').eq(index).focus();
                      }
                });




      }
  
var arrow = {
    left: 37,
    up: 38,
    right: 39,
    down: 40
},

ctrl = 17;
         $('.move').keydown(function (e) {              
                    if (e.ctrlKey && e.which === arrow.right) {
                        
                         var index = $('.move').index(this) + 1;                         
                         $('.move').eq(index).focus();
                         
                      }
                       if (e.ctrlKey && e.which === arrow.left) {
                      /*if (e.keyCode == ctrl && arrow.left) {*/
                         var index = $('.move').index(this) - 1;
                         $('.move').eq(index).focus();
                      }
                      if (e.ctrlKey && e.which === arrow.up) {
                         
                         var upd=$(this).attr('class').split(' ')[ 1 ];

                         var index = $('.'+upd).index(this) - 1;
                         $('.'+upd).eq(index).focus();
                      }
                      if (e.ctrlKey && e.which === arrow.down) {
                         
                         var upd=$(this).attr('class').split(' ')[ 1 ];

                         var index = $('.'+upd).index(this) + 1;
                         $('.'+upd).eq(index).focus();
                         
                      }
     });
      </script>
@endsection()