@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Manajemen Harga</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Manajemen Harga</li>
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
                                <li class="active"><a href="#alert-tab" data-toggle="tab">Manajemen Harga</a></li>
                                <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                                <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                
                                @include('POS::manajemenharga.modal')

                                <div id="alert-tab" class="tab-pane fade in active">
                                 
                                  <div class="row">

                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                      <div class="table-responsive">
                                        <table class="table tabelan table-bordered table-hover" id="tabel_m_price">
                                          <thead>
                                            <tr>
                                              <th>Kode - Nama Item</th>
                                              <th>Item Type</th>
                                              <th>Item Group</th>
                                              <th>Harga A</th>
                                              <th>Harga B</th>
                                              <th>Harga C</th>
                                              <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
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
                                    <div class="panel-body">
                                      <!-- Isi Content -->we we we
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
                                </div><!-- /div label-badge-tab -->
                              </div>
                    
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>


@endsection
@section("extra_scripts")
    @include('POS::manajemenharga/js/commander')
@endsection()