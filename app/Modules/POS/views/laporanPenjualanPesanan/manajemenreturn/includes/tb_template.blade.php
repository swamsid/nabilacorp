<div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 10px; padding-top:25px;padding-bottom:20px;">
   <div class="col-md-2 col-sm-3 col-xs-12">
      <label class="tebal">Nota Penjualan<font color="red">*</font></label>
   </div>
   <div class="col-md-4 col-sm-9 col-xs-12">
      <div class="form-group">
         <select class="form-control input-sm select2" id="cari_nota_sales" name="id_sales" style="width: 100% !important;">
            <option> - Pilih Nota Penjualan</option>
            +
         </select>
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <label class="tebal">Tanggal Return</label>
   </div>
   <div class="col-md-4 col-sm-9 col-xs-12">
      <div class="form-group">
         <input id="tanggalReturn" class="form-control input-sm datepicker2 " name="tanggal" type="text" value="{{ date('d-m-Y') }}">
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <label class="tebal">Metode Pembayaran</label>
   </div>
   <div class="col-md-4 col-sm-9 col-xs-12">
      <div class="form-group">
         <input type="text" name="pm_name" readonly="" class="form-control input-sm" id="pm_name">
      </div>
   </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px; padding-top:25px;padding-bottom:20px;">
   <div class="col-md-2 col-sm-3 col-xs-12">
      <label class="tebal">Detail Pelanggan</label>
   </div>
   <div class="col-md-10 col-sm-9 col-xs-12">
      <div class="form-group">
         <input type="text" name="c_name" readonly="" class="form-control input-sm" id="c_name">
         <input type="hidden" name="idSup" readonly="" class="form-control input-sm" id="id_sup">
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <label class="tebal">Total Tukar</label>
   </div>
   <div class="col-md-4 col-sm-9 col-xs-12">
      <div class="form-group">
         <input type="text" name="t_return" readonly="" class="form-control input-sm" id="t_return" value="">
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <label class="tebal">S Gross</label>
   </div>
   <div class="col-md-4 col-sm-9 col-xs-12">
      <div class="form-group">
         <input type="text" name="s_gross" readonly="" class="form-control input-sm" id="s_gross">
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <label class="tebal">Total Diskon</label>
   </div>
   <div class="col-md-4 col-sm-9 col-xs-12">
      <div class="form-group">
         <input type="text" name="total_diskon" readonly="" class="form-control input-sm totalGross" id="total_diskon">
         <input type="hidden" name="total_value" readonly="" class="form-control input-sm total_value" id="total_value">
         <input type="hidden" name="total_percent" readonly="" class="form-control input-sm total_percent" id="total_percent">
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <label class="tebal">Total Penjualan (Nett)</label>
   </div>
   <div class="col-md-4 col-sm-9 col-xs-12">
      <div class="form-group">
         <input type="text" name="s_net" readonly="" class="form-control input-sm totalGross" id="s_net">
      </div>
   </div>
</div>
<div class="table-responsive">
   <table class="table tabelan table-bordered" id="tabel-return-sales" width="100%">
      
         {{ csrf_field() }}
         <thead>
            <tr>
               <th width="18%">Nama</th>
               <th width="2%">Tukar</th>
               <th width="2%">Satuan</th>
               <th width="10%">Harga</th>
               <th width="10%">Harga Setelah Diskon</th>
               <th width="11%">Total</th>
               <th width="6%">Desc</th>
            </tr>
         </thead>
         <tbody id="dataDt">
         </tbody>
      
   </table>
</div>
<div align="right" style="padding-top: 15px;">
   <div id="div_button_save" class="form-group">
      <button type="button" id="button_save" class="btn btn-primary" onclick="simpanReturn()">Simpan Data</button>
   </div>
</div>