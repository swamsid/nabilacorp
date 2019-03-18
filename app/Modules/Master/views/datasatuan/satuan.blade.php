@extends('main')
@section('content')
<style type="text/css">
  td.details-control {
    background: url({{ asset('assets/images/details_open.png') }}) no-repeat center center;
    cursor: pointer;
}
 .sorting_disabled {
    
}
tr.details td.details-control {
     background: url({{ asset('assets/images/details_close.png')}}) no-repeat center center;
}

/*tr.details td.details-control {
    background: url({{ asset('assets/images/details_close.png')}}) no-repeat center center;
}*/
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Master Data Satuan</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Master Data Satuan</li>
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
              <li class="active"><a href="#alert-tab" data-toggle="tab">Master Data Satuan</a></li>
              <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
            </ul>
            
            <div id="generalTabContent" class="tab-content responsive">
              <div id="alert-tab" class="tab-pane fade in active">
                <div class="row" style="margin-top:-20px;">
                  <div align="right" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                    <a href="{{ url('master/datasatuan/tambah_satuan') }}">
                      <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                        <i class="fa fa-plus" aria-hidden="true">
                         &nbsp;
                        </i>Tambah Data
                      </button>
                    </a>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="table-responsive">
                      <table class="table tabelan table-hover table-responsive table-bordered" width="100%" cellspacing="0" id="tbl_customer">
                        <thead>
                          <tr>
                            {{-- <th class="sorting_disabled"></th> --}}
                            <th class="wd-15p">Kode</th>
                            <th class="wd-15p">Nama</th>
                            <th class="wd-15p">Detail</th>
                            <th class="wd-15p">Aksi</th>
                          </tr>
                        </thead>
                       
                        <tbody>

                        </tbody>

                                            
                      </table> 
                    </div>

                  </div>
                
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

</div>
@endsection

@section("extra_scripts")
  <script type="text/javascript">

  var tblSat = $('#tbl_customer').DataTable({
            processing: true,
            responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_satuan') }}',
            },
             columnDefs: [

                  {
                     targets: 2 ,
                     className: 'center d_id'
                  }, 
                ],
            "columns": [
            { "data": "s_code", "width" : "10%" },
            { "data": "s_name", "width" : "30%" },
            { "data": "s_detname", "width" : "40%" },
            { "data": "aksi","width" : "20%" },
            ]
      });


      function ubahStatus(id)
      {
        iziToast.question({
          close: false,
          overlay: true,
          displayMode: 'once',
          //zindex: 999,
          title: 'Ubah Status',
          message: 'Apakah anda yakin ?',
          position: 'center',
          buttons: [
            ['<button><b>Ya</b></button>', function (instance, toast) {
              $.ajax({
                url: baseUrl +'/master/datasatuan/ubahstatus',
                type: "get",
                dataType: "JSON",
                data: {id:id},
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    $('#tbl_customer').DataTable().ajax.reload();
                    iziToast.success({timeout: 5000,
                                        position: "topRight",
                                        icon: 'fa fa-chrome',
                                        title: '',
                                        message: 'Status brhasil di ganti.'});
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    $('#tbl_customer').DataTable().ajax.reload();
                    iziToast.error({position: "topRight",
                                      title: '',
                                      message: 'Status gagal di ubah.'});
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              }); 
            }, true],
            ['<button>Tidak</button>', function (instance, toast) {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            }],
          ]
        });
      }


         function edit(a) {
          var parent = $(a).parents('tr');
          var id = a;
          console.log(id);
          $.ajax({
               type: "get",
               url: '{{ route('edit_satuan') }}',
               data: {id},
               success: function(data){
               },
               complete:function (argument) {
                window.location=(this.url)
               },
               error: function(){
               
               },
               async: false
             });  
        }

    
</script>
@endsection