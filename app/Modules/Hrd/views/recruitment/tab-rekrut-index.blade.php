@php
  $lulusan = ['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D3', 'S1', 'S2', 'S3'];
@endphp


<div id="index-tab" class="tab-pane fade in active">
  <div class="row tamma-bg tamma-bg-form-top">
    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
          <label style="font-weight: bold;font-size: 16px;">Pencarian Berdasarkan :</label>
        </div>
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" style="float: right;">
          <button class="btn btn-primary btn-sm" onclick="cariDataIndex()"><i class="fa fa-search"></i></button>
          <button class="btn btn-default btn-sm" onclick="refreshTabelIndex()"><i class="fa fa-refresh"></i></button>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="col-md-2 col-sm-2 col-xs-12">
        <label>Tgl Awal</label>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <input type="text" class="form-control input-sm datepicker1" readonly="" id="head_tgl1" name="headTgl1" style="cursor: pointer;">
        </div>
      </div>

      <div class="col-md-2 col-sm-2 col-xs-12">
        <label>Tgl Akhir</label>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <input type="text" class="form-control input-sm datepicker2" readonly="" id="head_tgl2" name="headTgl2" style="cursor: pointer;">
        </div>
      </div>

      <div class="col-md-2 col-sm-2 col-xs-12">
        <label>Pendidikan Terakhir</label>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <select class="form-control input-sm" name="headGrade" id="head_grade">
            <option value="semua"> Tampilkan Semua </option>

              @foreach($lulusan as $index => $dataS)

                <option value="{{$dataS}}">{{$dataS}}</option>

              @endforeach

           </select>
        </div>
      </div>

      <div class="col-md-2 col-sm-2 col-xs-12">
        <label>Status Recruitment</label>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <select class="form-control input-sm" name="headStatus" id="head_status">
            <option value="semua"> Tampilkan Semua </option>
              @foreach($statusApply as $val)

                <option value="{{$val->p_st_id}}">{{$val->p_st_name}}</option>

              @endforeach
          </select>
        </div>
      </div>

    </div>

  </div>
  <div class="table-responsive" style="margin-top: 15px;">
    <table class="table tabelan table-hover table-bordered data-table" width="100%" cellspacing="0" id="tbl-index">
      <thead>
          <tr>
            <th class="wd-15p">No.</th>
            <th>Tanggal Apply</th>
            <th class="wd-15p">Nama Pelamar</th>
            <th class="wd-20p">No. HP</th>
            <th class="wd-20p">Email</th>
            <th class="wd-15p">Pedidikan</th>
            <th>Status</th>
            <th>Approval</th>
            <th style="text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
    
    </table> 
  </div>                                       
</div><!-- /div alert-tab -->