@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
   <!--BEGIN TITLE & BREADCRUMB PAGE-->
   <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
         <div class="page-title">Edit Master Consigne</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
         <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li class="active">Master Consigne</li><li><i class="fa fa-angle-right"></i>&nbsp;Edit Master Consigne&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Edit Master Consigne</a></li>
                  <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                  <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
               </ul>
               <div id="generalTabContent" class="tab-content responsive">
                  <div id="alert-tab" class="tab-pane fade in active">
                     <div class="row">
                        
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                           <div class="col-md-5 col-sm-6 col-xs-8" >
                              <h4>Edit Master Consigne</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                              <a href="{{ url('master/consigne/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>
                        </div>
                        
                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <form id="form_suplier" method="POST">
                              {{ csrf_field() }}
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-top:30px;padding-bottom:20px;">
                                 <div class="col-md-2 col-sm-3 col-xs-12">
                                    
                                    <label class="tebal">Nama Consigne</label>
                                    
                                 </div>
                                 <div class="col-md-4 col-sm-9 col-xs-12">
                                    <div class="form-group">
                                       <div class="input-icon right">
                                          <i class="fa fa-user"></i>
                                          <input type="text" id="perusahaan" name="c_name" class="form-control input-sm" value="{{$data->c_name}}">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-2 col-sm-3 col-xs-12">
                                    
                                    <label class="tebal">Company</label>
                                    
                                 </div>
                                 <div class="col-md-4 col-sm-9 col-xs-12">
                                    <div class="form-group">
                                       <div class="input-icon right">
                                          <i class="fa fa-building"></i>
                                          <input type="text" id="nama" name="c_company" class="form-control input-sm" value="{{$data->c_company}}">
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <div class="col-md-2 col-sm-3 col-xs-12">
                                    
                                    <label class="tebal">Hp 1</label>
                                    
                                 </div>
                                 <div class="col-md-4 col-sm-9 col-xs-12">
                                    <div class="form-group">
                                       <div class="input-icon right">
                                          <i class="glyphicon glyphicon-earphone"></i>
                                          <input type="text" id="hp" name="c_hp1" class="form-control input-sm hp" value="{{$data->c_hp1}}">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-2 col-sm-3 col-xs-12">
                                    
                                    <label class="tebal">Hp 2</label>
                                    
                                 </div>
                                 <div class="col-md-4 col-sm-9 col-xs-12">
                                    <div class="form-group">
                                       <div class="input-icon right">
                                          <i class="glyphicon glyphicon-earphone"></i>
                                          <input type="text" id="hp" name="c_hp2" class="form-control input-sm hp" value="{{$data->c_hp2}}">
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Fax</label>
                                 </div>
                                 <div class="col-md-4 col-sm-9 col-xs-12">
                                    <div class="form-group">
                                       <div class="input-icon right">
                                          <i class="glyphicon glyphicon-envelope"></i>
                                          <input type="text" id="email" name="c_fax" class="form-control input-sm" value="{{$data->c_fax}}">
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Alamat</label>
                                 </div>
                                 <div class="col-md-4 col-sm-9 col-xs-12">
                                    <div class="form-group">
                                       <div class="input-icon right">
                                          <i class="fa fa-home"></i>
                                          <textarea id="alamat" name="c_address" class="form-control input-sm">{{$data->c_address}}</textarea>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-2 col-sm-3 col-xs-12">
                                    
                                    <label class="tebal">Keterangan</label>
                                    
                                 </div>
                                 <div class="col-md-10 col-sm-9 col-xs-12">
                                    <div class="form-group">
                                       <div class="input-icon right">
                                          <textarea id="keterangan" name="c_info" class="form-control input-sm" >{{$data->c_info}}</textarea>
                                       </div>
                                    </div>
                                 </div>

                              </div>
                              <div align="right">
                                 <div class="form-group" align="right">
                                    <button type="button" onclick="edit()" class="btn btn-primary">Update Data</button>
                                 </div>
                              </div>
                              
                           </form>
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
@section('extra_scripts')
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script>
   $(document).ready(function(){
      var extensions = {
      "sFilterInput": "form-control input-sm",
      "sLengthSelect": "form-control input-sm"
      }
      //fix to issue select2 on modal when opening in firefox
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};
      var extensions = {
      "sFilterInput": "form-control input-sm",
      "sLengthSelect": "form-control input-sm"
      }
      // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);

      //mask money
      $('.hp').inputmask("9999 9999 9999");
   });

   function edit()
   {
      $.ajax({
         type: "POST",
         url: baseUrl + '/master/consigne/update/{{$data->c_id}}',
         data: $('#form_suplier').serialize(),
         success: function(a){
         if(a.status=="sukses")
         {
            toastr["success"]("Consigne Berhasil diupdate", "Sukses");
            window.location = (baseUrl+'/master/consigne/index');
         }
         },
            error: function(){
            toastr["error"]("Terjadi Kesalahan", "Error");
         },
      // async: false
      });
   }

</script>
@endsection