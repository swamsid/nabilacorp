<table id="tabel_d_sales_dt" class="table tabelan table-hover table-bordered table-striped" width="100%" cellspacing="0">
    <thead>
       <tr>
          <th align="center"  width="1%">No</th>
          <th align="center"  width="3%">Tanggal</th>
          <th align="center"  width="15%">Nota</th>
          <th align="center"   width="17%">Pelanggan/ Alamat</th>                              
          <th align="center"   width="17%">Disc Rp</th>                              
          <th align="center"   width="17%">Disc % (Rp)</th>                              
          <th align="center"   width="15%">Total Pembelian</th>
          <th align="center" >Terbayar</th>                                       
       </tr>
    </thead>
    <tbody>
    	@foreach($posPesanan as $index => $pos)
    	 <tr>
          <td>{{$index+1}}</td> 
          <td>{{date('d-M-Y',strtotime($pos->s_date))}}</td> 
          <td>{{$pos->s_code}}</td> 
          <td>{{$pos->s_nama_cus}} - {{$pos->s_alamat_cus}}</td>           
          <td>{{$pos->s_disc_percent}}</td> 
          <td>{{$pos->s_disc_value}}</td> 
          <td>{{$pos->s_net}}</td> 
          <td>{{$pos->s_bayar}}</td> 
       </tr>
    	@endforeach
    </tbody>
</table>


    <div class="float-left" style="width: 30vw;">
      <table >
        <tr>
          <td>Diskon % (Rupiah)</td>
          <td>:</td>                    
          <td align="right">{{number_format($total_discountPercent,2,',','.')}}</td>
        </tr>
        <tr>        
          <td>Diskon Rupiah</td>
          <td>:</td>
          <td align="right">{{number_format($total_discountvalue,2,',','.')}}</td>
        </tr>
        <tr>
          <td>DPP</td>
          <td>:</td>
          <td align="right">0,00</td>
        </tr>
        <tr>
          <td>Grand Total</td>
          <td>:</td>
          <td align="right">{{number_format($grand_total,2,',','.')}}</td>          
        </tr>
      </table>
    </div>
		