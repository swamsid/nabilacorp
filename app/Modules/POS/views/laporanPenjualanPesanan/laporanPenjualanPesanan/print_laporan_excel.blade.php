<table id="tabel_d_sales_dt" class="table tabelan table-hover table-bordered table-striped" width="100%" cellspacing="0">
    <thead>
       <tr>
          <th align="center" width="5%">No</th>
          <th align="center" width="10%">Tanggal</th>
          <th align="center"  width="15%">No Ref</th>
          <th align="center"   width="17%">Pelanggan</th>                              
          <th align="center"   width="15%">Piutang</th>                    
          <th align="center"   width="15%">Sisa Piutang</th>                    
          <th width="13%">Tgl bayar</th>                                 
          <th  width="15%">Jml Bayar</th>          
       </tr>
        
    </thead>
    <tbody>
    	@foreach($data as $index => $master)    		
    		<tr>
    			<td>{{$index+1}}</td>
    			<td>{{$master->r_date}}</td>
    			<td>{{$master->r_code}}</td>
    			<td>{{$master->r_customer_name}}</td>
    			<td>{{$master->r_value}}</td>
    			<td>{{$master->rd_outstanding}}</td>
    			<td>{{$master->rd_datepay}}</td>
    			<td>{{$master->rd_value}}</td>    			    			
    		</tr>
    	@endforeach
    </tbody>
</table>


		<div class="float-left" style="width: 30vw;">
			<table >
				<tr>
					<td>Total Piutang</td>
					<td>:</td>										
					<td align="right">{{number_format($totalPiutang,2,',','.')}}</td>
				</tr>
				<tr>				
					<td>Total Bayar</td>
					<td>:</td>
					<td align="right">{{number_format($jmlBayar,2,',','.')}}</td>
				</tr>
				<tr>
					<td>Sisa Piutang</td>
					<td>:</td>
					<td align="right">{{number_format($sisaPiutang,2,',','.')}}</td>					
				</tr>
			</table>
		</div>
		