@extends('main')
@section('content')
<style type="text/css">
   .ui-autocomplete { z-index:2147483647; }
   .select2-container { margin: 0; }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
   <!--BEGIN TITLE & BREADCRUMB PAGE-->
   <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
         <div class="page-title">Form Membership</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
         <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li class="active">Membership</li>
         <li><i class="fa fa-angle-right"></i>&nbsp;Form Membership&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
      </ol>
      <div class="clearfix"></div>
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
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Form Membership</a></li>
                  <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                     <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
               </ul>
               <div id="generalTabContent" class="tab-content responsive" >
                  <div id="alert-tab" class="tab-pane fade in active">
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                           <div class="col-md-5 col-sm-6 col-xs-8">
                              <h4>Form Membership</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                              <a href="{{ url('nabila/membership/member') }}" class="btn">
                              <i class="fa fa-arrow-left"></i>
                              </a>
                           </div>
                        </div>
                       
                        <!-- START div#header_form -->
                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:15px;" id="header_form">
                           <form id="form_m_customer" class="form-horizontal" method="post" style="padding: 3mm;margin-left:2mm;margin-right: 2mm">
                              {{ csrf_field() }}
                                 <input type="hidden" name="c_id" value="{{ $m_customer->c_id }}">
                                 
                                 <div class="row">
                                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                       <div class="form-group">
                                          <label class="col-xs-4 col-lg-4 control-label text-left">Nama Member</label>
                                          <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                             <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user" style="width: 15px"></i></span>
                                                <input type="text" class="form-control" id="name" name="c_name" value="{{ $m_customer->c_name }}"   placeholder="Masukkan Nama Member" style="text-transform: uppercase" />
                                             </div>
                                          </div>
                                       </div>
                                       
                                       <div class="form-group">
                                          <label class="col-xs-4 col-lg-4 control-label text-left">No. Telephone</label>
                                          <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                             <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone" style="width: 15px"></i></span>
                                                <input type="text" class="form-control" id="telp" name="c_hp" value="{{ $m_customer->c_hp }}"  placeholder="Masukkan Nomor Telepon" />
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-xs-4 col-lg-4 control-label text-left">Email</label>
                                          <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                             <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope" style="width: 15px"></i></span>
                                                <input type="text" class="form-control" id="email" name="c_email" value="{{ $m_customer->c_email }}"  placeholder="Masukkan Alamat Email" />
                                             </div>
                                          </div>
                                       </div>
                                    </article>
                                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                       <div class="form-group">
                                          <label class="col-xs-4 col-lg-4 control-label text-left">Tanggal Lahir</label>
                                          <div class="col-xs-8 col-lg-8">
                                             <input type="text" name="c_birthday" value="{{ $m_customer->c_birthday_label }}"  id="c_birthday" class="form-control">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-xs-4 col-lg-4 control-label text-left">Alamat Member</label>
                                          <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                             <textarea class="form-control" rows="5" style="resize: none;" placeholder="Masukkan Alamat Member" id="address" name="c_address">{{ $m_customer->c_address }}</textarea>
                                          </div>
                                       </div>
                                    </article>
                                 </div>
                              
                              
                                 <div class="row">
                                    <div class="col-md-12">
                                       <button class="btn btn-default" type="reset" onclick="window.location = '{{route("customer")}}'">
                                       <i class="fa fa-times"></i>
                                       &nbsp;Batal
                                       </button>
                                       <button class="btn btn-primary" type="button"  onclick="update_m_customer()">
                                       <i class="fa fa-floppy-o"></i>
                                       &nbsp;Simpan
                                       </button>
                                    </div>
                                 </div>
                              
                           </form>
                        </div>
                        <!-- END div#header_form -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--END PAGE WRAPPER-->              
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
@include('Nabila::member/js/form_functions')
@include('Nabila::member/js/form_commander')
@endsection