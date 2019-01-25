@extends('main')
@section('content')

            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Master Data Barang</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Master Data Barang</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Barang&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Barang</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row">

                              <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                                 <div class="col-md-5 col-sm-6 col-xs-8">
                                   <h4>Form Master Data Barang</h4>
                                 </div>
                                 <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                                   <a href="{{ url('master/item/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                 </div>
                              </div>


                         <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                            <form id='data'>
                              <input type="hidden" name="i_id" value="{{ $m_item->i_id }}">
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Kode Barang</label>

                                </div>
                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" id="i_code" name='i_code' value='{{ $m_item->i_code }}' class="form-control input-sm" readonly placeholder="(Auto)">
                                  </div>
                                </div>



                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Nama</label>

                                </div>
                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" id="nama" name='i_name' value='{{ $m_item->i_name }}' class="form-control input-sm">
                                      <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="nama-error"><small>Nama harus diisi.</small></span>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Min. Stock</label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="number" id='i_min_stock' name='i_min_stock' value='{{ $m_item->i_min_stock }}'  class="form-control">
                                      <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="satuan-error"><small>Min. Stock Harus Diisi</small></span>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Type</label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <select class="input-sm form-control select" name='i_type' data-selected='{{ $m_item->i_type }}' id="i_type">
                                        <option value="">~ Pilih Type ~</option>
                                        <option value="BJ">Barang Jual</option>
                                        <option value="BP">Barang Produksi</option>
                                        <option value="BB">Bahan Baku</option>
                                      </select>
                                      <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="type-error"><small>Type harus dipilih.</small></span>
                                  </div>
                                </div>
              

                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="row">
                                    
                                    <div class="col-md-3"><label class="tebal">Kelompok</label></div>
                                    <div class="form-group col-md-9">
                                        <select class="input-sm form-control select" name='i_group' data-selected='{{ $m_item->i_group }}' onchange="dinamis()" id="kelompok">
                                          <option value="">~ Pilih Kelompok ~</option>
                                          @foreach ($kelompok as $key => $value)
                                            <option value="{{$value->g_id}}">{{$value->g_name}}</option>
                                          @endforeach
                                        </select>
                                        <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="kelompok-error"><small>Kelompok harus dipilih.</small></span>
                                    </div>
                                  </div>
                                </div>

                                
                               

                                


                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Satuan Utama</label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <select class="input-sm form-control select" name='i_sat1' data-selected='{{ $m_item->i_sat1 }}' id="i_sat1">
                                        <option value="">~ Pilih Satuan ~</option>
                                        @foreach ($satuan as $key => $value)
                                          <option value="{{$value->s_id}}">{{$value->s_name}} ({{$value->s_detname}})</option>
                                        @endforeach
                                      </select>
                                      <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="satuan-error"><small>Satuan harus dipilih.</small></span>
                                  </div>
                                </div>
          
                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Isi Sat. Utama</label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="number" id='i_sat_isi1' name='i_sat_isi1' value='{{ $m_item->i_sat_isi1 }}' class="form-control" value='1' readonly>
                                      
                                  </div>
                                </div>                      

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Satuan Alternatif 1</label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <select class="input-sm form-control select" name='i_sat2' data-selected='{{ $m_item->i_sat2 }}' id="i_sat2">
                                        <option value="">~ Pilih Satuan ~</option>
                                        @foreach ($satuan as $key => $value)
                                          <option value="{{$value->s_id}}">{{$value->s_name}} ({{$value->s_detname}})</option>
                                        @endforeach
                                      </select>
                                      <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="satuan-error"><small>Satuan harus dipilih.</small></span>
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Isi Sat. Alternatif 1</label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="number" id='i_sat_isi2' name='i_sat_isi2' value='{{ $m_item->i_sat_isi2 }}' class="form-control">
                                      
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Satuan Alternatif 2</label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <select class="input-sm form-control select" name='i_sat3' data-selected='{{ $m_item->i_sat3 }}' id="i_sat3">
                                        <option value="">~ Pilih Satuan ~</option>
                                        @foreach ($satuan as $key => $value)
                                          <option value="{{$value->s_id}}">{{$value->s_name}} ({{$value->s_detname}})</option>
                                        @endforeach
                                      </select>
                                      <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="satuan-error"><small>Satuan harus dipilih.</small></span>
                                  </div>
                                </div>

                                
                                <div class="col-md-3 col-sm-4 col-xs-12">

                                    <label class="tebal">Isi Sat. Alternatif 2</label>

                                </div>

                                <div class="col-md-3 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="number" id='i_sat_isi3' name='i_sat_isi3' value='{{ $m_item->i_sat_isi3 }}' class="form-control">
                                      
                                  </div>
                                </div>                                

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Harga Satuan Utama</label>

                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" id="hargabeli" name='is_price1' value='{{ $d_item_supplier[0]->is_price1 }}' class="form-control input-sm">
                                      
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Harga Satuan Alternatif 1</label>

                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" id="hargabeli" name='is_price2' value='{{ $d_item_supplier[0]->is_price2 }}' class="form-control input-sm" readonly>
                                      
                                  </div>
                                </div>

                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Harga Satuan Alternatif 2</label>

                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" id="hargabeli" name='is_price3' value='{{ $d_item_supplier[0]->is_price3 }}' class="form-control input-sm" readonly>
                                      
                                  </div>
                                </div>


                                <div class="col-md-3 col-sm-4 col-xs-12">

                                      <label class="tebal">Detail</label>

                                </div>
                                <div class="col-md-9 col-sm-8 col-xs-12">
                                  <div class="form-group">
                                      <textarea class="form-control input-sm" name='i_det' value='{{ $m_item->i_det }}'>{{ $m_item->i_det }}</textarea>
                                  </div>
                                </div>
                                
                                
                                <div id="dinamis"> 
                                  @foreach ($d_item_supplier as $x => $supplier)
                                    <div class="dinamis{{ $x }}">
                                      <div class="col-md-2" style="margin-right: 68px;">

                                            <label class="tebal">Supplier</label>

                                      </div>
                                      
                                      <div class="col-md-9">
                                        <div class="form-group col-sm-5">
                                          <select class="input-sm form-control" name="is_supplier[]" data-selected="{{ $supplier->s_id }}" data-text="{{ $supplier->s_company }}">
                                              <option value="">~ Pilih Supplier ~</option>
                                          </select>
                                          <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="supplier-error0"><small>Supplier harus diisi.</small></span>
                                        </div>
                                        
                                    
                                      <div class="form-group col-sm-2" style="display: flex">
                                        <button style="margin-right: 1mm" type="button" class="btn btn-primary" type="button" name='button'  onclick="tambah()"> <i class="fa fa-plus" ></i> </button>
                                        @if($x > 0)
                                          <button type="button" class="btn btn-danger" type="button" name='button'  onclick="kurang({{ $x }})"> <i class="fa fa-minus"></i> </button>
                                        @endif
                                      </div>
                                    </div>
                                  </div>
                                  @endforeach
                                </div>
                              <div class="row">
                                <div class="col-xs-12" style="display: flex;justify-content: flex-end;"> 
                                  <button class="btn btn-primary" type="button" onclick="perbarui()">Simpan</button>
                                </div>
                              </div>
                          

                      </form>
                </div>
             </div>
           </div>
         </div>


@endsection
@section("extra_scripts")
  @include('Master::databarang/js/format_currency')
  @include('Master::databarang/js/form_commander')
  
  <script>
    iddinamis = {{ $x }};
    $(document).ready(function(){
        $('select').each(function(){
            var value = $(this).attr('data-selected');
            var text = $(this).attr('data-text');
            if(value != undefined && value != '') {
                if(text != undefined && text != '') {
                    var opt = $('<option value="' + value + '">' + text + '</option>')
                    $(this).append(opt);
                }

                $(this).val(value).trigger('change');
            }
        });
    });
  </script>
@endsection
